import os, time, json
import gensim

SCRIPT_PATH = os.path.dirname(os.path.realpath(__file__))
MODEL_PATH  = os.path.join(SCRIPT_PATH, 'model/')
# Load word2vec model
print('Loading Model')
model = gensim.models.Word2Vec.load(os.path.join(MODEL_PATH, 'word2vecWiki.model'), mmap='r')
print('Model loaded')

def is_locked(filepath):
	"""Checks if a file is locked by opening it in append mode.
	If no exception thrown, then the file is not locked.
	"""
	locked = None
	file_object = None
	if os.path.exists(filepath):
		try:
			buffer_size = 8
			# Opening file in append mode and read the first 8 characters.
			file_object = open(filepath, 'a', buffer_size)
			if file_object:
				locked = False
		except IOError:
			locked = True
		finally:
			if file_object:
				file_object.close()
	else:
		print("%s not found." % filepath)
	return locked

def wait_for_files(filepaths):
	"""Checks if the files are ready.

	For a file to be ready it must exist and can be opened in append
	mode.
	"""
	wait_time = 1
	for filepath in filepaths:
		# If the file doesn't exist, wait wait_time seconds and try again
		# until it's found.
		while not os.path.exists(filepath):
			print(filepath, " hasn't arrived. Waiting ", wait_time, " seconds.")
			time.sleep(wait_time)
		# If the file exists but locked, wait wait_time seconds and check
		# again until it's no longer locked by another process.
		while is_locked(filepath):
			print(filepath, " is currently in use. Waiting ", wait_time, " seconds.")
			time.sleep(wait_time)

		process(filepath)

def process(filepath):
	with open(filepath, 'r') as fin:
		content = fin.read().splitlines(True)
	with open(filepath, 'w') as fout:
		fout.writelines(content[1:])

	if len(content) > 0:
		data = json.loads(content[0])
		words = data['user_msg'].split(" ")
		output = ''
		if len(words) > 1:
			output = 'Similaridade entre ' + words[0] + " e " + words[1] + " = " + str(model.similarity(words[0], words[1]))
		else:
			output = 'O vetor de ' + words[0] + " = " + str(model.wv[words[0]])

		with open('./tmp/' + data['tmp_file'], 'w') as out_file:
			out_file.write(output)

if __name__ == '__main__':
	file = [r"./tmp/log.txt"]
	wait_time = 1
	while True:
		wait_for_files(file)
		time.sleep(wait_time)