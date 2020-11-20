import folium

location = [45.5, -122.7]
map = folium.Map(location=location, zoom_start=6, tiles="Stamen Terrain")

feature_group = folium.FeatureGroup(name="My Map")
feature_group.add_child(folium.Marker(location=[45, -122], popup="New Marker",
                            icon=folium.Icon(color="green")))
map.add_child(feature_group)
map.save("Map1.html")
