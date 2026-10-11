from funções import verificar_email, verificar_idade, verificar_nome, criar_json

print("--cadastro e usuarios--")

nome = input('digite o nome de seu usuarios: ')

if verificar_nome(nome):
    print("nome valido \n")

    email = input('digite seu email: ')

    if verificar_email(email):
        print("email valido \n")
    

        try:
            idade = int(input('digite sua idade: '))

            if verificar_idade(idade):
                print("idade valida \n")

                criar_json(nome,email,idade)
                print("arquivo json criado com suceso")
        except ValueError:
            print("numero invlido \n")

    else:
        print("idade invalida \n")
        
else:
    print("nome invalido \n")

print("codigo encerrado")


