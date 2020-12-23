from models import Movie, User

user = User("John")
new_movie = Movie("Home Alone", "comedy", True)
next_movie = Movie("The Matrix", "sci-fi")
user.movies.append(new_movie)
user.movies.append(next_movie)
print(user.movies)
print(user.watched_movies())
user.save_to_file()
