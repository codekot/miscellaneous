import folium
import pandas as pd
import json

starting_location = [45.5, -122.7]
map = folium.Map(location=starting_location, zoom_start=6, tiles="Stamen "
                                                                 "Terrain")

df = pd.read_csv("volcanoes-2020.tsv", delimiter="\t", )
print(df.info())
print(df.head())

feature_group = folium.FeatureGroup(name="My Map")


def color_code(code):
    # The date of the last known eruption (from the Smithsonian Institution,
    # Global Volcanism Program) D1	Last known eruption 1964 or later D2
    # Last known eruption 1900-1963 D3	Last known eruption 1800-1899 D4
    # Last known eruption 1700-1799 D5	Last known eruption 1500-1699 D6
    # Last known eruption A.D. 1-1499 D7	Last known eruption B.C. (
    # Holocene) U	Undated, but probable Holocene eruption Q	Quaternary
    # eruption(s) with the only known Holocene activity being hydrothermal
    # ?	Uncertain Holocene eruption
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
    location = (row[4], row[5])
    volcano_name = row[1]
    color = color_code(row[9])
    feature_group.add_child(
        folium.CircleMarker(location=location, radius=10, popup=volcano_name,
                            fill_color=color, color="grey", fill_opacity=0.85))

county_json = json.load(open("gz_2010_us_050_00_500k.json", "r"))
feature_group.add_child(folium.GeoJson(data=county_json))

map.add_child(feature_group)
map.save("Map1.html")
