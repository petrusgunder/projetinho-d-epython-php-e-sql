import re
import json
import os
from cryptography.fernet import Fernet

if not os.path.exists("chave.key"):
  chave = Fernet.generate_key()
  with open("chave.key", "wb") as arquivo_chave:
    arquivo_chave.write(chave)
else:
  with open("chave.key", "rb") as arquivo_chave:
    chave = arquivo_chave.read()

fernet = Fernet(chave)

def verificar_email(dado):
    padrao = r"^[\w\.-]+@[\w\.-]+\.\w+$"
    if re.match(padrao, dado) and len(dado) <= 100:
        return True
    else:
        return False

def verificar_nome(nome) :
    if len(nome) > 2 and len(nome) <= 40:
        padrao = r"^[A-Za-zÀ-ÿ\s\-]{3,}$"
        return bool(re.match(padrao, nome))
    else:
        return False

def verificar_idade(idade):
    if idade > 0 and idade < 122:
        return True
    else:
        return False

import json
import os


def criar_json(nome, email, idade):
  novo_usuario = {"nome": nome, "email": email, "idade": idade}
  usuarios = []

  if os.path.exists("dados_criptografados.json"):
    with open("dados_criptografados.json", "rb") as arquivo:
      conteudo_criptografado = arquivo.read()
      if conteudo_criptografado:
        try:
          conteudo_descriptografado = fernet.decrypt(conteudo_criptografado)
          usuarios = json.loads(conteudo_descriptografado.decode("utf-8"))
        except Exception:
          usuarios = []

  usuarios.append(novo_usuario)

  texto_json = json.dumps(usuarios, ensure_ascii=False)
  bytes_criptografados = fernet.encrypt(texto_json.encode("utf-8"))

  with open("dados_criptografados.json", "wb") as arquivo:
    arquivo.write(bytes_criptografados)

  print("Arquivo dados_criptografados.json atualizado com sucesso!")