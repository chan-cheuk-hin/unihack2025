# Desciption

This is the backend portion of the application.

Written in php, it provides high level api calls to interact with the database (adding and retrieving diary entries) for the application, as well as running the emotion classifier in python to label the mood give emotion score.

# API reference

Endpoint: https://cchandrew.com/api/unihack2025/

## Add Entry ["action": "add_entry"]
- Add an entry to the database
- Params: {date:YYYY-MM-DD, title, text}
- Response: If date does not exist, {response: "entry_inserted"}. If date exists, "{response: date_already_exists"}

## Get Entry ["action": "get_entry"]
- Fetch the data of a single diary entry provided date
- Params: {date:YYYY-MM-DD}
- Response: If date does not exist, {response: "date_does_not_exist"}. If date exists, "{response: ok", "title", "text", "label", "score"}

## Get Dates ["action": "get_dates"]
- Fetch the list of dates from the database
- Params: None
- Response: Array of "date": "value" pairs

All responses contain : "response" & "response_time" (seconds)

# Mood & Emotion Score Classifier

emotion_classifier.py takes in a piece of text as an argument, outputs the mood class and the score.

Model used: https://huggingface.co/j-hartmann/emotion-english-distilroberta-base

Dummy data for database: 
- https://www.kaggle.com/datasets/madhavmalhotra/journal-entries-with-labelled-emotions
- https://www.kaggle.com/datasets/parulpandey/emotion-dataset