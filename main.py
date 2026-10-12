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

                try:
                    criar_json(nome, email, idade)
                    print("arquivo json criado com sucesso")
                except:
                    print("\nerro 500 );")
                    print("algo ocorreu ao enviar dados para o servidor")
                    print("estamos corrigindo")
            
            else:
                print("\nerro 400 );")
                print("idade invalida \n")
                print("O usuario digitou uma idade negativa ou maior que a idade humanamente possivel")

        except ValueError:
            print("\nerro 400 );")
            print("numero invalido \n")
            print("Usuario digitou letras ou caracteres não numéricos no campo de idade")

    else:
        print("\nerro 400 );")
        print("email invalido \n")
        print("usuario digitou o email fora da forma de um email")
        
else:
    print("\nerro 400  ); ")
    print("nome invalido \n")
    print("O usuario tentou utilizar caracteres especiais ou digitou um nome curto demais")

print("\ncodigo encerrado")