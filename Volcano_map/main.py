import folium
import pandas as pd

starting_location = [45.5, -122.7]
map = folium.Map(location=starting_location, zoom_start=6, tiles="Stamen Terrain")

df= pd.read_csv("volcanoes-2020.tsv", delimiter="\t",)
print(df.info())
print(df.head())
# print(df.iloc[1,4:6])

volcanoes_coord = []
for row in df.values:
    volcanoes_coord.append([row[4], row[5]])

feature_group = folium.FeatureGroup(name="My Map")

for volcano in volcanoes_coord:
    feature_group.add_child(folium.Marker(location=volcano, popup="New Marker",
                            icon=folium.Icon(color="green")))

map.add_child(feature_group)
map.save("Map1.html")
