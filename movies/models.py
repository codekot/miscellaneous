import json


class Movie:
    def __init__(self, name, genre, watched=False):
        self.name = name
        self.genre = genre
        self.watched = watched

    def __repr__(self):
        return f"<Movie: {self.name}," \
               f"genre: {self.genre}, watched: {self.watched}>"

    def json(self):
        return {
            "name": self.name,
            "genre": self.genre,
            "watched": self.watched
        }

    @classmethod
    def from_json(cls, json_data):
        return cls(
            name=json_data["name"],
            genre=json_data["genre"],
            watched=json_data["watched"]
        )


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
        self.movies = list(
            filter(lambda movie: movie.name != name, self.movies))

    def watched_movies(self):
        return list(filter(lambda movie: movie.watched, self.movies))

    def to_json(self):
        return {
            "name": self.name,
            "movies": [
                movie.json() for movie in self.movies
            ]
        }

    def save_to_json(self):
        with open(f"{self.name}.json", "w") as f:
            json.dump(self.to_json(), f)

    @classmethod
    def from_json(cls, json_data):
        user = cls(name=json_data["name"])
        user.movies = [
            Movie.from_json(movie) for movie in json_data["movies"]
        ]
        return user
