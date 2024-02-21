import openai
import sys
import json

# with open('/hidden.txt') as file:
# openai.api_key = file.read()
openai.api_key = "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"


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
        # text = json.loads(choices.message.content)
        # text = text["pertanyaan"]
        token = response.usage.total_tokens
    except Exception as e:
        print('ERROR:', e)

    # return '{"pertanyaan":' + str(text) + ',"token":' + str(token) + '}'
    return text
    # return '{"name": "John", "age": 30, "city": "New York"}'


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
        # pos: int = bot_response.find('\nAI: ')
        # bot_response = bot_response[pos + 4:]
        return bot_response
    else:
        bot_response = 'Something went wrong...'


def main():
    prompt_list: list[str] = [
        {"role": "system",
            "content": """
Anda adalah seorang bot yang akan membantu dosen dalam merangkai 10 buah pertanyaan kritis dalam bahasa Indonesia untuk menguji pengetahuan mahasiswa. Pertanyaan-pertanyaan ini akan dirangkai berdasarkan topik yang dimasukkan pengguna. Anda akan menggunakan template pertanyaan berdasarkan Taksonomi Bloom untuk menghasilkan pertanyaan yang sesuai dengan tingkat pemahaman yang diinginkan.


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

Dari masing-masing kategori di atas, buat 5 pertanyaan understanding dan 5 pertanyaan remembering. Usahakan untuk tidak bertanya tentang sejarah yang hanya menyangkut waktu dan juga JANGAN MENGGUNAKAN TEMPLATE PERTANYAAN YANG SAMA LEBIH DARI 2X, tetapi Perluas/Perdalam materi berdasarkan kata-kata kunci yang dimasukkan pengguna.

hasilkan respons dalam format JSON. Berikut merupakan contoh respon :

    [
        {
        "question": "What is supervised learning method?",
        "answer": "Supervised learning method is an approach in machine learning where the model learns from labeled data, which means the model learns by mapping input to desired output.",
        "category": "remembering"
        },
        {
        "question": "How do you choose an appropriate model in machine learning?",
        "answer": "Choosing a model in machine learning involves understanding the characteristics of the data, prediction objectives, and model performance. This includes considering model complexity, generalization, and adaptation to the data type.",
        "category": "remembering"
        },
        {
        "question": "Why is cross-validation important in machine learning?",
        "answer": "Cross-validation is used to evaluate the performance of a model by dividing the data into training and testing subsets. It helps measure how well the model can generalize to unseen data.",
        "category": "remembering"
        },
        {
        "question": "How can we evaluate the performance of a model in machine learning?",
        "answer": "The performance evaluation of a model in machine learning can be done using metrics such as accuracy, precision, recall, F1-score, and ROC-AUC curve. This helps to understand how well the model predicts unseen data.",
        "category": "understanding"
        },
        {
        "question": "What is the difference between overfitting and underfitting in machine learning?",
        "answer": "Overfitting occurs when the model is too complex and 'memorizes' the training data, thus it cannot generalize well to new data. Underfitting occurs when the model is too simple to capture patterns in the training data, thus its performance is poor on test data.",
        "category": "understanding"
        },
        {
        "question": "How can we avoid overfitting in machine learning?",
        "answer": "Strategies to avoid overfitting in machine learning include using cross-validation, model regularization (such as L1 or L2 penalties), dimensionality reduction, and collecting more diverse or additional data features.",
        "category": "understanding"
        }
    ]
"""
         },
    ]

    while True:
        user_input: str = input('You: ')
        response: str = get_bot_response(user_input, prompt_list)
        print(f'Bot: {response}')
    # response: str = get_bot_response(topic, prompt_list)
    # print(str(response))


if __name__ == '__main__':
    main()
