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

    def add_movie(self, name, genre, watched=False):
        movie = Movie(name, genre, watched)
        self.movies.append(movie)

    def delete_movie(self, name):
        self.movies = list(filter(lambda movie: movie.name!=name, self.movies))

    def watched_movies(self):
        return list(filter(lambda movie: movie.watched, self.movies))

    def save_to_file(self):
        with open(f"{self.name}.txt", "w") as f:
            f.write(self.name + '\n')
            for movie in self.movies:
                f.write(f"{movie.name},{movie.genre},{movie.watched}")
