import requests
from bs4 import BeautifulSoup
import sys


def get_metadata_from_url(url):
    #Hace la solicitud http para ver los metadatos
    response = requests.get(url)

    #Se verifica si la solicitud fue exitosa
    if response.status_code == 200:
        #Utilizamos la libreria BeautifulSoup para analizar el contenido html
        soup = BeautifulSoup(response.text, 'html.parser')

        #En esta parte inspeccionaremos la estructura html
        title = soup.find('meta', {'name': 'citation_title'})['content']
        authors = [author['content'] for author in soup.find_all('meta', {'name': 'citation_author'})]
        journal = soup.find('meta', {'name': 'citation_journal_title'})['content']
        volume = soup.find('meta', {'name': 'citation_volume'})['content']
        year = soup.find('meta', {'name': 'citation_publication_date'})['content']

        
        #retornamos los metadatos que hayamos encontrado
        return {
            'title' : title,
            'authors' : authors,
            'journal' : journal,
            'volume' : volume,
            'year' : year,

            }
    else:
        print(f"Error al obtener la pagina. Codigo de estado: {response.status_code}")
        return None

def generate_bib_entry(metadata):
    """
    Genera el formato de bibtex con los metadatos.
    """

    bib_entry = f"@article{{{metadata['authors'][0].split()[0].lower()}{metadata['year']},\n"
    bib_entry += f"  title = {{{metadata['title']}}},\n"
    bib_entry += f"  author = {{{' and '.join(metadata['authors'])}}},\n"
    bib_entry += f"  journal = {{{metadata['journal']}}},\n"
    bib_entry += f"  volume = {{{metadata['volume']}}},\n"
    bib_entry += f"  year = {{{metadata['year']}}},\n"

    bib_entry += "}"

    return bib_entry


def main(urle):
    #solicitamos la url
    url = urle

    #Recaba los metadatos de la url
    metadata = get_metadata_from_url(url)

    #Muestra la informacion
    if metadata:
        print("\nMetadatos obtenidos:")
        for key, value in metadata.items():
            print(f"{key}: {value}")

    #Se genera el .bib
    bib_entry = generate_bib_entry(metadata)

    #Se muestra la entrada.bib
    print("\nEntrada .bib generada: ")
    print(bib_entry)

    #Se puede guardar el archivo .bib en un archivo
    with open ('referencia.bib', 'w' ,encoding='utf-8') as file:
        file.write(bib_entry)
    

if __name__ == "__main__":
    urle = sys.argv[1]
    main(urle)
