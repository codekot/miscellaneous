import folium
import pandas as pd

starting_location = [45.5, -122.7]
map = folium.Map(location=starting_location, zoom_start=6, tiles="Stamen Terrain")

df= pd.read_csv("volcanoes-2020.tsv", delimiter="\t",)
print(df.info())
print(df.head())
# print(df.iloc[1,4:6])

volcanoes_coord = []

feature_group = folium.FeatureGroup(name="My Map")

def color_code(code):
    if code == "D1":
        return "red"
    elif code == "D2":
        return "orange"
    elif code == "D3":
        return "green"
    elif code == "D4":
        return "lightblue"
    elif code == "D5":
        return "blue"
    elif code == "D6":
        return "darkblue"
    else:
        return "gray"

for row in df.values:
    location = [row[4], row[5]]
    volcano_name = row[1]
    color = color_code(row[9])
    feature_group.add_child(folium.Marker(location=location, popup=volcano_name,
                            icon=folium.Icon(color=color)))

map.add_child(feature_group)
map.save("Map1.html")
