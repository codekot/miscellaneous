class Movie:
    def __init__(self, name, genre, watched=False):
        self.name = name
        self.genre = genre
        self.watched = watched

    def __repr__(self):
        return f"<Movie: {self.name}, genre: {self.genre}>"


class User:
    def __init__(self, name):
        self.name = name
        self.movies = []

    def __repr__(self):
        return f"<User {self.name}>"

    def watched_movies(self):
        return list(filter(lambda movie: movie.watched, self.movies))
