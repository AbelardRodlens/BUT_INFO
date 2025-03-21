import requests
import json
from datetime import datetime, timezone
import os
import time

# Vos identifiants API IGDB
CLIENT_ID = 'ump28lo2jfyu2wb4ghtfietxop2172'
ACCESS_TOKEN = 'v842k1b41uc1tyvzhkl90d719g5ahl'

# URL de base pour l'API IGDB
BASE_URL = "https://api.igdb.com/v4/games"
PROGRESS_FILE = "progress.json"
OUTPUT_FILE = "GamesDATA.json"

# Fonction pour récupérer les données des jeux
def fetch_games(offset):
    headers = {
        "Client-ID": CLIENT_ID,
        "Authorization": f"Bearer {ACCESS_TOKEN}"
    }

    # Champs que nous voulons récupérer, avec traduction en français si possible
    fields = """
        name,
        summary,
        summary_fr,
        platforms.name,
        platforms.platform_logo.url,
        genres.name,
        cover.url,
        involved_companies.company.name,
        involved_companies.developer,
        involved_companies.publisher,
        first_release_date,
        artworks.url,
        game_modes.name,
        themes.name,
        total_rating,
        total_rating_count
    """

    # Requête pour récupérer les jeux triés par total_rating_count
    query = f"fields {fields}; limit 50; offset {offset}; sort total_rating_count desc; where language = 'fr';"

    response = requests.post(BASE_URL, headers=headers, data=query)

    if response.status_code == 200:
        return response.json()
    else:
        print(f"Erreur {response.status_code}: {response.text}")
        return []

# Fonction pour ajuster les tailles d'images
def get_image_sizes(url):
    if url:
        return {
            "thumb": url.replace("t_thumb", "t_thumb"),
            "original": url.replace("t_thumb", "t_original")
        }
    return {"thumb": "N/A", "original": "N/A"}

# Fonction pour transformer les données en un format clair
def transform_game_data(games):
    cleaned_data = []
    for game in games:
        developers = []
        publishers = []

        # Parcours des entreprises impliquées pour séparer développeurs et éditeurs
        for company in game.get("involved_companies", []):
            if company.get("developer"):
                developers.append(company["company"]["name"])
            if company.get("publisher"):
                publishers.append(company["company"]["name"])

        # Gestion des dates de sortie invalides
        release_date = "N/A"
        if game.get("first_release_date"):
            try:
                release_date = datetime.fromtimestamp(
                    game["first_release_date"], tz=timezone.utc
                ).strftime('%Y-%m-%d')
            except (ValueError, OSError):
                release_date = "Invalid Date"

        # Récupération de la description en français ou anglais
        description_en = game.get("summary", "N/A")
        description_fr = game.get("summary_fr", description_en)

        # Construction des données nettoyées
        game_data = {
            "title": game.get("name", "N/A"),
            "description": {
                "en": description_en,
                "fr": description_fr
            },
            "platforms": [p["name"] for p in game.get("platforms", [])],
            "genres": [g["name"] for g in game.get("genres", [])],
            "cover": get_image_sizes(game.get("cover", {}).get("url")),
            "developers": developers,
            "publishers": publishers,
            "artworks": [get_image_sizes(a["url"]) for a in game.get("artworks", [])],
            "game_modes": [gm["name"] for gm in game.get("game_modes", [])],
            "themes": [t["name"] for t in game.get("themes", [])],
            "release_date": release_date,
            "total_rating": game.get("total_rating", "N/A"),
            "total_rating_count": game.get("total_rating_count", 0)
        }
        cleaned_data.append(game_data)
    return cleaned_data

# Fonction pour charger ou initialiser le suivi
def load_progress():
    if os.path.exists(PROGRESS_FILE):
        with open(PROGRESS_FILE, "r", encoding="utf-8") as file:
            return json.load(file)
    return {"offset": 0, "games_retrieved": 0}

# Fonction pour sauvegarder le suivi
def save_progress(progress):
    with open(PROGRESS_FILE, "w", encoding="utf-8") as file:
        json.dump(progress, file, ensure_ascii=False, indent=4)

# Fonction principale
def main():
    progress = load_progress()
    offset = progress["offset"]
    games_retrieved = progress["games_retrieved"]

    print(f"Reprise à l'offset {offset}, {games_retrieved} jeux déjà récupérés.")

    # Chargement des données existantes si le fichier de sortie existe
    if os.path.exists(OUTPUT_FILE):
        with open(OUTPUT_FILE, "r", encoding="utf-8") as file:
            all_games = json.load(file)
    else:
        all_games = []

    while games_retrieved < 10000:
        print(f"Récupération des jeux à partir de l'offset {offset}...")
        games = fetch_games(offset)

        if not games:
            print("Aucune donnée supplémentaire récupérée, arrêt.")
            break

        # Transformation et ajout des données nettoyées
        cleaned_data = transform_game_data(games)
        all_games.extend(cleaned_data)

        # Mise à jour du suivi
        games_retrieved += len(cleaned_data)
        offset += 50
        progress = {"offset": offset, "games_retrieved": games_retrieved}
        save_progress(progress)

        print(f"{games_retrieved} jeux récupérés jusqu'à présent.")

        # Sauvegarde intermédiaire des données
        with open(OUTPUT_FILE, "w", encoding="utf-8") as file:
            json.dump(all_games, file, ensure_ascii=False, indent=4)

        # Délai d'une seconde pour éviter de trop solliciter l'API
        time.sleep(1)

    print(f"Processus terminé : {games_retrieved} jeux sauvegardés.")

# Exécution
if __name__ == "__main__":
    main()
