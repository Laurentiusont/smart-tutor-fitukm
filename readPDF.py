
# importing required modules
from PyPDF2 import PdfReader

# creating a pdf reader object
reader = PdfReader(
    'D:\\laravel\\smart-tutor\\storage\\app\\public\\file\\EBUkF92wRR3pTn0rrkbHLdhzwluwCjg5LkCvgEup.pdf')

# printing number of pages in pdf file
print(len(reader.pages))

# getting a specific page from the pdf file
page = reader.pages[0]

# extracting text from page
text = page.extract_text()
print(text)
