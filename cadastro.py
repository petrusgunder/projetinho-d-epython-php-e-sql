import json
import re

def verificar_email(dado):
  padrao = r"^[\w\.-]+@[\w\.-]+\.\w+$"
  if re.match(padrao, dado):
    return True
  return False

print("--cadastro e usuarios--")

nome = input('digite o nome de seu usuarios: ')
email = input('digite seu email: ')

if nome == '':
    print('nome invalido!!!')
else:
    if verificar_email(email):
    
        try:
            idade = int(input('digite sua idade: '))
        except ValueError:
            print("numero invalido")
        else:
            if idade > 0:
                Usuario = [
                    {"nome": nome, "email": email,"idade": idade}
                ]

                with open("dados.json", "w") as arquivo:
                    json.dump(Usuario, arquivo)

                print("Arquivo dado.json criado com sucesso!")
            else:
                print("idade negativa invalida")
    else:
        print("emial invalido!")