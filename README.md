# Projeto de sistema para afungaz

# O projeto deverá ter disponível a reserva dos chalés, e também da quadra/campo.

# O projeto também deverá SEMPRE armazenar os logs de quem agendou, mesmo que ele cancele.

# Seria interessante fazer validações também se a pessoa realmente foi e pegou o chalé. Para termos certeza de que ela não reservou atoa e pegou o hoário/dia de outra pessoa.



# Anotações
A relação para criarmos novos admins vai ser função exclusiva para um admin já existente.
O objetivo vai ser ele apenas adicionar um cpf dentro de uma tela simples de cadastro, e o insert já vai ser feito na tabela admin.
A validação deverá ser feita no msm momento que receber o login

# Outro adicional interessante é criarmos um cadastro afungaz. Ele irá efetuar o login direto pelo sabium, e no primeiro login dele ele terá que preencher alguns campos que será armazenado na tabela cadastro_afungaz
# Campos:  
    Ramal int
    
    Departamento Varchar (Não deixar disponível para preenchimento. Ver se temos departamentos salvos já em alguma tabela do sabium. Se não tiver, vamos adicionar manualmente as opções e deixar com que ele selecione. Se possível, vamos deixar também para o Admin cadastrar esses novos departamentos)
    
    Negócio. (e-commerce, atacado, varejo físico...)

    id_tipo_funcionario





# Próximo passo vai ser validar se a data já esta cadastrada antes de realizar o insert.

