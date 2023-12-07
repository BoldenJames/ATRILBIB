import requests
from bs4 import BeautifulSoup
import PyPDF2
import io
from reportlab.lib.pagesizes import letter
from reportlab.pdfgen import canvas
import sys

def get_metadata_from_url(url):
    try:
        response = requests.get(url)
        response.raise_for_status()
    except requests.exceptions.RequestException as err:
        print(f"Error al obtener la página: {err}")
        return None

    if response.status_code == 200:
        soup = BeautifulSoup(response.text, 'html.parser')

        title_tag = soup.find('meta', {'name': 'citation_title'})
        title = title_tag['content'] if title_tag else None

        authors_tags = soup.find_all('meta', {'name': 'citation_author'})
        authors = [author['content'] for author in authors_tags] if authors_tags else None

        journal_tag = soup.find('meta', {'name': 'citation_journal_title'})
        journal = journal_tag['content'] if journal_tag else None

        volume_tag = soup.find('meta', {'name': 'citation_volume'})
        volume = volume_tag['content'] if volume_tag else None

        year_tag = soup.find('meta', {'name': 'citation_publication_date'})
        year = year_tag['content'] if year_tag else None

        article_number_tag = soup.find('meta', {'name': 'citation_article_number'})
        article_number = article_number_tag['content'] if article_number_tag else None

        url_tag = soup.find('meta', {'name': 'citation_fulltext_html_url'})
        url = url_tag['content'] if url_tag else None

        issn_tag = soup.find('meta', {'name': 'citation_issn'})
        issn = issn_tag['content'] if issn_tag else None

        abstract_tag = soup.find('meta', {'name': 'citation_abstract'})
        abstract = abstract_tag['content'] if abstract_tag else None

        doi_tag = soup.find('meta', {'name': 'citation_doi'})
        doi = doi_tag['content'] if doi_tag else None

        return {
            'title': title,
            'authors': authors,
            'journal': journal,
            'volume': volume,
            'year': year,
            'article_number': article_number,
            'url': url,
            'issn': issn,
            'abstract': abstract,
            'doi': doi,
        }
    else:
        print(f"Error al obtener la página. Código de estado: {response.status_code}")
        return None
    

def get_metadata_from_pdf_url(pdf_url):
    try:
        response = requests.get(pdf_url)
        response.raise_for_status()
    except requests.exceptions.RequestException as err:
        print(f"Error al obtener el PDF: {err}")
        return None

    if response.status_code == 200:
        with io.BytesIO(response.content) as pdf_file:
            pdf_reader = PyPDF2.PdfReader(pdf_file)
            text = ""
            for page_number in range(len(pdf_reader.pages)):
                text += pdf_reader.pages[page_number].extract_text()


        return {'pdf_text': text}
    else:
        print(f"Error al obtener el PDF. Código de estado: {response.status_code}")
        return None
    

def generate_bib_entry(metadata):
    if metadata and metadata['authors'] is not None and len(metadata['authors']) > 0:
        bib_entry = f"@article{{{metadata['authors'][0].split()[0].lower()}{metadata['year']},\n"
        
        if metadata['title'] is not None:
            bib_entry += f"  title = {{{metadata['title']}}},\n"

        if metadata['authors'] is not None and len(metadata['authors']) > 0:
            bib_entry += f"  author = {{{' and '.join(metadata['authors'])}}},\n"

        if metadata['journal'] is not None:
            bib_entry += f"  journal = {{{metadata['journal']}}},\n"

        if metadata['volume'] is not None:
            bib_entry += f"  volume = {{{metadata['volume']}}},\n"

        if metadata['year'] is not None:
            bib_entry += f"  year = {{{metadata['year']}}},\n"

        if metadata['article_number'] is not None:
            bib_entry += f"  article-number = {{{metadata['article_number']}}},\n"

        if metadata['url'] is not None:
            bib_entry += f"  url = {{{metadata['url']}}},\n"

        if metadata['issn'] is not None:
            bib_entry += f"  issn = {{{metadata['issn']}}},\n"

        if metadata['abstract'] is not None:
            bib_entry += f"  abstract = {{{metadata['abstract']}}},\n"

        if metadata['doi'] is not None:
            bib_entry += f"  doi = {{{metadata['doi']}}},\n"

        bib_entry += "}"
        return bib_entry
    else:
        print("Error: No se encontraron autores en los metadatos o metadata es None.")
        return None

def export_to_pdf(metadata, bib_entry):
    filename = 'referencia.pdf'
    pdf = canvas.Canvas(filename, pagesize=letter)
    
    try:
        pdf.drawString(72, 800, "Metadatos:")
        pdf.drawString(72, 780, "-" * 40)

        y_position = 760
        for key, value in metadata.items():
            pdf.drawString(72, y_position, f"{key}: {value}")
            y_position -= 15

        pdf.drawString(72, y_position, "")
        pdf.drawString(72, y_position - 15, "Entrada .bib generada:")
        pdf.drawString(72, y_position - 30, "-" * 40)

        y_position -= 45
        for line in bib_entry.split('\n'):
            pdf.drawString(72, y_position, line)
            y_position -= 15

    finally:
        pdf.save()

def main(urle):
    url = urle

    if url.lower().endswith('.pdf'):
        metadata = get_metadata_from_pdf_url(url)
    else:
        metadata = get_metadata_from_url(url)

    if metadata:
        print("\nMetadatos obtenidos:")
        for key, value in metadata.items():
            print(f"{key}: {value}")

        bib_entry = generate_bib_entry(metadata)

        if bib_entry:
            print("\nEntrada .bib generada:")
            print(bib_entry)

            export_to_pdf(metadata, bib_entry)
            print(f"Los datos se han exportado a 'referencia.pdf'")
        else:
            print("Error al generar la entrada .bib.")
    else:
        print("Error: No se pudieron obtener metadatos desde la URL o el PDF.")

if __name__ == "__main__":
    urle = sys.argv[1]
    main(urle)
