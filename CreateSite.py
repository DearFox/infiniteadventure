import os


def create_title(text):
    return f"<h3>{text}</h3>"

def create_data(text):
    return f'<a class="data" name="{text}" href="#{text}">{text}</a>'

def create_br():
    return "<br>"

def create_history_is_historying():
    return '<center><img src="History-is-historying.gif" title="Итория исторится"></center>'

def create_comment(text):
    parts = text.split("|")
    return f'<div class="comment"><center><h3>{parts[0]}</h3></center><i>{parts[1]}</i></div>'

def create_offcomment(text):
    parts = text.split("|")
    return f'<details><summary>Спойлер</summary><div class="comment"><center><h3>{parts[0]}</h3></center><i>{parts[1]}</i></div></details>'

def create_img(text):
    return f'<center><img class="img" src="{text}"></center>'

def create_text(text):
    return f"<p>{text}</p>"

def process_line(line):
    global page_title_temp
    if line.startswith("[title]"):
        page_title_temp = line[len("[title]"):].strip()
        return create_title(line[len("[title]"):].strip())
    elif line.startswith("[data]"):
        return create_data(line[len("[data]"):].strip())
    elif line.startswith("[]"):
        return create_br()
    elif line.startswith("[...]"):
        return create_history_is_historying()
    elif line.startswith("[comment]"):
        return create_comment(line[len("[comment]"):].strip())
    elif line.startswith("[offcomment]"):
        return create_offcomment(line[len("[offcomment]"):].strip())
    elif line.startswith("[img]"):
        return create_img(line[len("[img]"):].strip())
    elif line.startswith("#"):
        return ""
    else:
        return create_text(line.strip())

def process_file(file_name):
    result_array = []
    with open(file_name, "r", encoding="utf-8") as file:
        for line in file:
            result = process_line(line)
            if result:
                result_array.append(result)
    
    html_content = "\n".join(result_array)
    
    with open("template.html", "r", encoding="utf-8") as template_file:
        template = template_file.read()
        template = template.replace("{content}", html_content)
        template = template.replace("{num_page}", os.path.splitext(os.path.basename(file_name))[0])
        template = template.replace("{title}", page_title_temp)
    
    script_dir = os.path.dirname(os.path.abspath(__file__))
    html_file_name = os.path.join(script_dir, os.path.splitext(os.path.basename(file_name))[0] + ".html")
    
    with open(html_file_name, "w", encoding="utf-8") as html_file:
        html_file.write(template)

# Обработка всех текстовых файлов в папке "pages"
script_dir = os.path.dirname(os.path.abspath(__file__))
pages_dir = os.path.join(script_dir, "pages")
for file_name in os.listdir(pages_dir):
    if file_name.endswith(".txt"):
        file_path = os.path.join(pages_dir, file_name)
        process_file(file_path)
        print(page_title_temp)
        print(file_path)