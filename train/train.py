# -*- coding: utf-8 -*-
import os
import sys
import bz2
import logging
import multiprocessing

import gensim

SCRIPT_PATH = os.path.dirname(os.path.realpath(__file__))
DATA_PATH   = os.path.join(SCRIPT_PATH, 'data/')
MODEL_PATH  = os.path.join(SCRIPT_PATH, 'model/')

#DICTIONARY_FILEPATH = os.path.join(DATA_PATH, 'dict.txt')
DICTIONARY_FILEPATH = os.path.join(DATA_PATH, 'dictbrwiki.txt')
#SOURCE_FILEPATH = os.path.join(DATA_PATH, 'literature-corpus.txt')
SOURCE_FILEPATH = os.path.join(DATA_PATH, 'brwiki-latest-pages-articles.xml.bz2')

class MyCorpus(object):
    def __iter__(self):
        dictionary = gensim.corpora.Dictionary(line.lower().split() for line in open(SOURCE_FILEPATH))
        for line in open(SOURCE_FILEPATH):
            yield dictionary.doc2bow(line.lower().split())


if __name__ == '__main__':

    # Check if the required files have been downloaded
    if not SOURCE_FILEPATH:
        print('Wikipedia articles dump could not be found..')
        print('Please see README.md for instructions!')
        sys.exit()


    # Get number of available cpus
    cores = multiprocessing.cpu_count()

    if not os.path.exists(MODEL_PATH):
        os.makedirs(MODEL_PATH)

    # Initialize logging
    logging.basicConfig(format='%(asctime)s : %(levelname)s : %(message)s', level=logging.INFO)

    if not os.path.isfile(DICTIONARY_FILEPATH):
        logging.info('Dictionary has not been created yet..')
        logging.info('Creating dictionary..')

        # Construct corpus
        corpus = gensim.corpora.WikiCorpus(SOURCE_FILEPATH)
        #corpus = gensim.corpora.TextCorpus(SOURCE_FILEPATH)

        # Remove words occuring less than 20 times, and words occuring in more
        # than 10% of the documents. (keep_n is the vocabulary size)
        corpus.dictionary.filter_extremes(no_below=20, no_above=0.1, keep_n=100000)

        # Save dictionary to file
        corpus.dictionary.save_as_text(DICTIONARY_FILEPATH)

        del corpus

    # Load dictionary from file
    dictionary = gensim.corpora.Dictionary.load_from_text(DICTIONARY_FILEPATH)

    # Construct corpus using dictionary
    corpus = gensim.corpora.WikiCorpus(SOURCE_FILEPATH, dictionary=dictionary)
    #corpus = gensim.corpora.TextCorpus(SOURCE_FILEPATH, dictionary=dictionary)

    class SentencesIterator:
        def __init__(self, corpus):
            self.corpus = corpus

        def __iter__(self):
            for sentence in self.corpus.get_texts():
                #yield list(map(lambda x: x.decode('utf-8'), sentence))
                yield list(map(lambda x: x, sentence))

    # Initialize simple sentence iterator required for the Word2Vec model
    sentences = SentencesIterator(corpus)

    logging.info('Training word2vec model..')
    model = gensim.models.Word2Vec(sentences=sentences, size=300, min_count=1, window=5, workers=cores)

    # Save model
    logging.info('Saving model..')
    model.save(os.path.join(MODEL_PATH, 'word2vecWiki.model'))
    logging.info('Done training word2vec model!')
