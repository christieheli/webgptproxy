import openai
import gradio as gr
import tiktoken

API_KEY = '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'
openai.api_key = API_KEY


g_title = '<h1><center>二建客服AI-demo版</center></h1>'

g_group_info = '''
2023年二级建造师-零基础入门训练营 单价0 免费先体验一下课程内容\n 购买链接: https://www.hqwx.com/ke/detail/29754?group_id=29754&fromblock=0&packageId=0\n
2023年二级建造师-AI系统班 单价980\n 购买链接: https://www.hqwx.com/ke/detail/27506?group_id=27506&fromblock=0&packageId=0\n
2023年二级建造师-AI畅学班 单价1980\n 购买链接: https://www.hqwx.com/ke/detail/27505?group_id=27505&fromblock=0&packageId=0\n 
2023年二级建造师-云私塾Pro尊享班 单价3582\n 购买链接: https://www.hqwx.com/ke/detail/27504?group_id=27504&fromblock=0&packageId=0\n
'''

g_prompt = [
    {'role':'system', 'content':'你是环球网校(https://www.hqwx.com/)负责二级建造师的销售客服，会介绍二建考试政策考试时间以及详细介绍每个课程的介绍、价格和购买链接'},
    #{"role": "system", "name": "example_user", "content": "你好"},
    #{"role": "system", "name": "example_assistant", "content": "您好，我是环球网校负责二建报考的老师，看到您咨询二建考试/买了二建的考试书籍/兑换了课程，是准备参加今年二建的考试对吗？"},
    #{"role": "system", "name": "example_user", "content": "报考二建"},
    #{"role": "system", "name": "example_assistant", "content": "您好，您是第一次考吗？可以提供一下学历信息，看看符不符合报考条件"},
    {"role": "system", "name": "example_user", "content": "挂靠"},
    {"role": "system", "name": "example_assistant", "content": "现在国家是严厉打击挂靠的，但市场一定有需求。（一句带过，不过度纠缠） "},
    {"role": "system", "name": "example_user", "content": "课程班型"},
    {"role": "system", "name": "example_assistant", "content": g_group_info},
    {"role": "system", "name": "example_user", "content": "班型课程"},
    {"role": "system", "name": "example_assistant", "content": 'https://tinyurl.com/3au75c9a'},
    #{"role": "system", "name": "example_user", "content": "最低价"},
    #{"role": "system", "name": "example_assistant", "content": '您好，具体课程优惠折扣，您可以留个联系方式，我让老师联系您'},
]
g_tips = '您可以在这里输入您想咨询的二建相关的信息'



def openai_chat_create(prompt):
    #print(prompt)
    #print("============================================================\n\n")
    
    model_id = 'gpt-3.5-turbo'
    response = openai.ChatCompletion.create(
        model = model_id,
        messages = prompt,
        temperature = 0.2,
    )
    print(response)
    assistant_messages = response['choices'][0]['message']['content']
    
    #assistant_messages = '您好，我是环球网校负责二建报考的老师，看到您咨询二建考试/买了二建的考试书籍/兑换了课程，是准备参加今年二建的考试对吗？'
    return assistant_messages



def num_tokens_from_messages(messages, model="gpt-3.5-turbo-0301"):
    """Returns the number of tokens used by a list of messages."""
    try:
        encoding = tiktoken.encoding_for_model(model)
    except KeyError:
        encoding = tiktoken.get_encoding("cl100k_base")
    if model == "gpt-3.5-turbo-0301":  # note: future models may deviate from this
        num_tokens = 0
        for message in messages:
            num_tokens += 4  # every message follows <im_start>{role/name}\n{content}<im_end>\n
            for key, value in message.items():
                num_tokens += len(encoding.encode(value))
                if key == "name":  # if there's a name, the role is omitted
                    num_tokens += -1  # role is always required and always 1 token
        num_tokens += 2  # every reply is primed with <im_start>assistant
        return num_tokens
    else:
        raise NotImplementedError(f"""num_tokens_from_messages() is not presently implemented for model {model}.
See https://github.com/openai/openai-python/blob/main/chatml.md for information on how messages are converted to tokens.""")


def call_back_block(input, history):
    global g_prompt
    prompt = g_prompt
    
    history = history or []
    s = list(sum(history, ()))
    s.append(input)
    i = 1
    for text in s:
        dict_item = {}
        role = 'user'
        if i % 2 == 0:
            role = 'assistant'
        dict_item['role'] = role
        dict_item['content'] = text
        prompt.append(dict_item)
        i = i + 1
        #print(messages)
        #print("============================================================\n\n")
        
    output = openai_chat_create(prompt)
    history.append((input, output))
    return history, history



def start():
    block = gr.Blocks()
    with block:
        gr.Markdown(g_title)
        chatbot = gr.Chatbot()
        message = gr.Textbox(placeholder=g_tips)
        state = gr.State()
        submit = gr.Button("咨询")
        submit.click(call_back_block, inputs=[message, state], outputs=[chatbot, state])

    block.launch(debug = True)


if __name__ == "__main__":
   start()