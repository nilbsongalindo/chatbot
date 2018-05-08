# -*- coding: utf-8 -*-
import os

import gensim

SCRIPT_PATH = os.path.dirname(os.path.realpath(__file__))
MODEL_PATH  = os.path.join(SCRIPT_PATH, 'model/')

if __name__ == '__main__':

    # Load word2vec model
    model = gensim.models.Word2Vec.load(os.path.join(MODEL_PATH, 'word2vecWiki.model'), mmap='r')

    word1 = 'crian\xc3\xa7a'
    word2 = 'amor'
    word3 = 'mulher'

    #print(word1 + ' + ' + word2 + ' - ' + word3)
    print(word1 + ' - ' + word2)
    print('')
    for word, sim in model.most_similar(positive=[word1, word2], negative=[]):
        print('\"%s\"\t- similarity: %g' % (word, sim))
    print('')

    print('Similarity between ' + word1 + ' and ' + word2 + ':')
    print(model.similarity(word1, word2))