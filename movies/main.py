from models import Movie, User

#user = User("John")
#new_movie = Movie("Home Alone", "comedy", True)
#next_movie = Movie("The Matrix", "sci-fi")
#user.movies.append(new_movie)
#user.movies.append(next_movie)

#user.save_to_file()
user = User.load_from_file(filename="John.txt")

print(user.movies)
print(user.watched_movies())