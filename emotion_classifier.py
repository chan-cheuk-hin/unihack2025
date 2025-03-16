import sys
import pandas as pd
from transformers import pipeline

text = sys.argv[1]
model = pipeline("text-classification", model="j-hartmann/emotion-english-distilroberta-base")

emotion = model(text)[0]
label = emotion["label"]
score = emotion["score"]

print(f"{label}#{score}")