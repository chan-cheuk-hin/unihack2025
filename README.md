# Desciption

This is the backend portion of the application.

Written in php, it provides high level api calls to interact with the database (adding and retrieving diary entries) for the application, as well as running the emotion classifier in python to label the mood give emotion score.

# API reference

Endpoint: https://cchandrew.com/api/unihack2025/

## Add Entry
- Params: {date:YYYY-MM-DD, title, text}
- Response: If date does not exist, {response: "entry_inserted"}. If date exists, "{response: date_already_exists"}

## Get Entry
- Params: {date:YYYY-MM-DD}
- Response: If date does not exist, {response: "date_does_not_exist"}. If date exists, "{response: ok", "title", "text", "label", "score"}

All responses contain : "response" & "response_time" (seconds)