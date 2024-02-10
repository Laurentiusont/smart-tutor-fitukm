import openai
import sys

with open('hidden.txt') as file:
    openai.api_key = file.read()


def get_api_response(prompt: str) -> str | None:
    text: str | None = None

    try:
        response: dict = openai.chat.completions.create(
            model='gpt-3.5-turbo',
            messages=prompt,
            temperature=0.9,
            # max_tokens=300,
            top_p=1,
            frequency_penalty=0,
            presence_penalty=0.6,
            stop=['Human:', 'AI:']
        )
        # print(response)
        choices: dict = response.choices[0]
        # print(response)
        text = choices.message.content
    except Exception as e:
        print('ERROR:', e)

    return text


def update_list(message: str, pl: list[str]):
    pl.append(message)


def create_prompt(message: str, pl: list[str]) -> str:
    # p_message: str = f'\nHuman: {message}'
    # update_list(p_message, pl)
    pl.append({"Human": message})
    prompt: str = ''.join(pl)
    return prompt


def get_bot_response(message: str, pl: list[str]) -> str:
    # prompt: str = create_prompt(message, pl)
    pl.append({"role": "user", "content": message})
    bot_response: str = get_api_response(pl)

    if bot_response:
        # update_list(bot_response, pl)
        # pl.append({"role": "assistant", "content": bot_response})
        pos: int = bot_response.find('\nAI: ')
        # bot_response = bot_response[pos + 4:]
    else:
        bot_response = 'Something went wrong...'

    return bot_response


def main(topic):
    prompt_list: list[str] = [
        {"role": "system",
            "content": """
Anda adalah seorang bot yang akan membantu dosen dalam merangkai 10 buah pertanyaan kritis dalam bahasa Indonesia untuk menguji pengetahuan mahasiswa. Pertanyaan-pertanyaan ini akan dirangkai berdasarkan topik yang dimasukkan pengguna. Anda akan menggunakan template pertanyaan berdasarkan Taksonomi Bloom untuk menghasilkan pertanyaan yang sesuai dengan tingkat pemahaman yang diinginkan.

### Tentang Taksonomi Bloom:
[Taksonomi Bloom](https://id.wikipedia.org/wiki/Taksonomi_Bloom) adalah sebuah kerangka kerja yang digunakan untuk mengklasifikasikan tujuan pendidikan menjadi tingkat yang berbeda-beda, mulai dari yang paling sederhana hingga yang paling kompleks.

### Template Pertanyaan:
Berikut adalah template pertanyaan yang dapat digunakan:

#### Remembering (Mengingat):
1. Apa itu …?
2. Di mana …?
3. Bagaimana ___ terjadi?
4. Mengapa …?
5. Bagaimana Anda akan menunjukkan …?
6. Yang mana …?
7. Bagaimana …?
8. Kapan ___ terjadi?
9. Bagaimana Anda akan menjelaskan …?
10. Bagaimana Anda akan menggambarkan..?
11. Bisakah Anda mengingat …?
12. Bisakah Anda memilih …?
13. Bisakah Anda menyebutkan tiga …?
14. Siapa yang …?

#### Understanding (Memahami):
1. Bagaimana Anda akan mengklasifikasikan jenis …?
2. Bagaimana Anda akan membandingkan …? Kontraskan …?
3. Akankah Anda menyatakan atau menafsirkan dengan kata-kata Anda sendiri …?
4. Bagaimana Anda akan memperbaiki makna …?
5. Fakta atau ide apa yang menunjukkan …?
6. Apa ide utama dari …?
7. Pernyataan mana yang mendukung …?
8. Bisakah Anda menjelaskan apa yang sedang terjadi …?
9. Apa yang dimaksud …?
10. Apa yang dapat Anda katakan tentang …?
11. Mana yang merupakan jawaban terbaik …?
12. Bagaimana Anda akan merangkum …?

Dari masing-masing kategori di atas, ambil 5 pertanyaan. Usahakan untuk tidak bertanya tentang sejarah yang hanya menyangkut waktu dan juga JANGAN MENGGUNAKAN TEMPLATE PERTANYAAN YANG SAMA LEBIH DARI 2X, tetapi Perluas/Perdalam materi berdasarkan kata-kata kunci yang dimasukkan pengguna.

hasilkan respons dalam format JSON. Berikut merupakan contoh respon :
{
    "pertanyaan": [
        {
            "pertanyaan": "Apa itu metode supervised learning?",
            "jawaban": "Metode supervised learning adalah pendekatan dalam machine learning di mana model belajar dari data yang telah diberi label, yang berarti model belajar dengan memetakan input ke output yang diinginkan.",
            "kategori": "remembering"
        },
        {
            "pertanyaan": "Bagaimana cara memilih model yang sesuai dalam machine learning?",
            "jawaban": "Pemilihan model dalam machine learning melibatkan pemahaman tentang karakteristik data, tujuan prediksi, dan kinerja model. Ini termasuk mempertimbangkan kompleksitas model, generalisasi, dan penyesuaian dengan jenis data.",
            "kategori": "remembering"
        },
        {
            "pertanyaan": "Mengapa validasi silang (cross-validation) penting dalam machine learning?",
            "jawaban": "Validasi silang digunakan untuk mengevaluasi kinerja model dengan membagi data menjadi subset pelatihan dan pengujian. Ini membantu mengukur seberapa baik model dapat melakukan generalisasi ke data yang tidak terlihat sebelumnya.",
            "kategori": "remembering"
        },
        {
            "pertanyaan": "Bagaimana kita dapat mengevaluasi kinerja model dalam machine learning?",
            "jawaban": "Evaluasi kinerja model dalam machine learning dapat dilakukan dengan menggunakan metrik seperti akurasi, presisi, recall, F1-score, dan kurva ROC-AUC. Ini membantu untuk memahami seberapa baik model memprediksi data yang tidak terlihat sebelumnya.",
            "kategori": "understanding"
        },
        {
            "pertanyaan": "Apa perbedaan antara overfitting dan underfitting dalam machine learning?",
            "jawaban": "Overfitting terjadi ketika model terlalu kompleks dan 'menghafal' data pelatihan, sehingga tidak dapat menggeneralisasi dengan baik pada data baru. Underfitting terjadi ketika model terlalu sederhana untuk memahami pola dalam data pelatihan, sehingga kinerjanya buruk pada data uji.",
            "kategori": "understanding"
        },
        {
            "pertanyaan": "Bagaimana kita dapat menghindari overfitting dalam machine learning?",
            "jawaban": "Strategi untuk menghindari overfitting dalam machine learning meliputi penggunaan validasi silang, regulasi model (seperti penalti L1 atau L2), pengurangan dimensi, dan pengumpulan data yang lebih banyak atau diversifikasi fitur.",
            "kategori": "understanding"
        }
    ]
}
"""
         },
    ]

    # while True:
    #     user_input: str = input('You: ')
    #     response: str = get_bot_response(user_input, prompt_list)
    #     print(f'Bot: {response}')
    response: str = get_bot_response(topic, prompt_list)
    return response


if __name__ == '__main__':
    main(sys.argv[1])
