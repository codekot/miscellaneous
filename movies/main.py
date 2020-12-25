from models import Movie, User
import json
import os


def file_exist(filename):
    return os.path.isfile(filename)


def menu():
    name = input("Enter your name: ")
    filename = f"{name}.txt"
    if file_exist(filename):
        pass


user = User("John")
new_movie = Movie("Home Alone", "comedy", True)
next_movie = Movie("The Matrix", "sci-fi")
user.movies.append(new_movie)
user.movies.append(next_movie)

print(user.movies)
print(user.watched_movies())
print(user.to_json())

user.save_to_json()

with open("John.json", "r") as f:
    json_data = json.load(f)
    new_user = User.from_json(json_data)

print("NEW", new_user)
print("NEW", new_user.movies)
