import openai

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


def main():
    prompt_list: list[str] = [
        {"role": "system",
            "content": """
Anda adalah bot yang akan membantu dosen dalam merangkai 10 pertanyaan kritis dalam bahasa indonesia untuk menguji pengetahuan mahasiswa. Pertanyaan dirangkai berdasarkan daftar kata yang di input user dan digabungkan dengan template pertanyaan taksonomi bloom. Tempalate pertanyaan bloom terdiri dari dua kategori yaitu remembering dan understanding, yang masing - masing terdapat 15 pertanyaan dan 12 pertanyaan. Berikut merupakan list template pertanyaan yang dapat digunakan  :
            
            berikut adalah template pertanyaan dengan kategori Remembering :
            1. What is …?
            2. Where is …?
            3. How did ___ happen?
            4. Why did …?
            5. How would you show …?
            6. Which one …?
            8. How is …?
            9. When did ___ happen?
            10. How would you explain …?
            11. How would you describe..?
            12. Can you recall …?
            13. Can you select …?
            14. Can you list the three …?
            15. Who was …?

            berikut adalah template pertanyaan dengan kategori Understanding :
            1. How would you classify the type of …?
            2. How would you compare …? Contrast …?
            3. Will you state or interpret in your own words …?
            4. How would you rephrase the meaning …?
            5. What facts or ideas show …?
            6. What is the main idea of …?
            7. Which statements support …?
            8. Can you explain what is happening …?
            9. What is meant …?
            10. What can you say about …?
            11. Which is the best answer …?
            12. How would you summarize …? 
            
            Dari 15 pertanyaan remembering dan 12 pertanyaan understanding diatas, ambil masing-masing 5 pertanyaan. Untuk setiap pertanyaan yang dibuat cantumkan kategori darimana pertanyaan tersebut diambil apakah dari tempalate remembering atau understanding. 
            . Anda sedikit memperluas materi diluar kata - kata yang diinput untuk membuat pertanyaan semakin kritis.
            Sebisa mungkin untuk tidak menanyakan sejarah dimana jawabannya adalah waktu.

            berikan response dalam format json.
            """


         },
        {
            "role": "user",
            "content": "Algoritma, Data training, Prediksi, Neural network, Klasifikasi"
        },
        {
            "role": "assistant",
            "content": """

                        {
                        "pertanyaan": [
                            {
                            "pertanyaan": "Apa itu algoritma?",
                            "jawaban": "Algoritma adalah serangkaian langkah-langkah logis untuk menyelesaikan suatu masalah atau mencapai suatu tujuan.",
                            "kategori" : "remembering"
                            },
                            {
                            "pertanyaan": "Bagaimana cara menjelaskan data training?",
                            "jawaban": "Data training adalah kumpulan data yang digunakan untuk melatih model atau algoritma dalam machine learning. Data ini berisi contoh-contoh yang sudah diketahui hasilnya sehingga dapat digunakan untuk membuat prediksi pada data baru.",
                            "kategori" : "remembering"
                            },
                            {
                            "pertanyaan": "Mengapa kita perlu melakukan prediksi?",
                            "jawaban": "Prediksi dilakukan untuk memperoleh informasi atau estimasi tentang hal-hal yang belum terjadi berdasarkan data yang ada. Hal 
                        ini membantu dalam pengambilan keputusan atau perencanaan di masa depan.",
                        "kategori" : "remembering"
                            },
                            {
                            "pertanyaan": "Apa itu neural network?",
                            "jawaban": "Neural network adalah jaringan komputasi yang terinspirasi oleh struktur dan fungsi otak manusia. Ia terdiri dari banyak unit 
                        pemrosesan (neuron) yang saling terhubung, dan dapat digunakan untuk mempelajari pola-pola kompleks atau mengenali data yang rumit.",
                        "kategori" : "remembering"
                            },
                            {
                            "pertanyaan": "Bagaimana kita bisa menggunakan neural network untuk klasifikasi?",
                            "jawaban": "Untuk klasifikasi, kita dapat menggunakan neural network dengan memberikan input data yang ingin diklasifikasikan ke jaringannya. Jaringan ini akan mempelajari pola-pola dari data training dan menggunakan informasi tersebut untuk mengklasifikasikan data baru ke dalam kategori yang tepat.",
                            "kategori" : "understanding"

                            },
                        ]
                        }
                        """
        },
    ]

    while True:
        user_input: str = input('You: ')
        response: str = get_bot_response(user_input, prompt_list)
        print(f'Bot: {response}')


if __name__ == '__main__':
    main()
