# Backlog do Projeto: Amor em Linhas

Este documento serve para organizar as tarefas de desenvolvimento e manter um registro (Diário de Bordo) do que for sendo construído no projeto.

## 📋 Lista de Tarefas (Backlog)

### Prioridade Alta (Essencial para Profissionalização)
- [x] Mover o código legado para uma pasta `legacy/` por segurança.
- [x] Instalar o Framework Laravel na raiz do projeto (`composer create-project laravel/laravel .`).
- [x] Configurar conexão do banco de dados no arquivo `.env` do Laravel.
- [x] Criar as Migrations e Models equivalentes ao banco de dados atual (`produtos`, `banners`, `usuarios`, `pedidos`, etc).
- [x] Migrar as views atuais (HTML) para o sistema de templates Blade do Laravel.

### Prioridade Média (Boas Práticas e Integrações)
- [x] Implementar os Controllers para lidar com as regras de negócio de produtos, carrinho e perfil.
- [x] Implementar a autenticação (login/registro) usando o Laravel Breeze ou fortify.
- [ ] Estruturar adequadamente o CSS/JS na pasta `public/` e refinar o estilo.
- [ ] Preparar a integração com gateways de pagamento (Mercado Pago / Stripe) como alternativas ao PIX.

### Prioridade Alta (Próxima Sessão)
- [ ] **Barra de Pesquisa**: Implementar a lógica de busca no backend para que a barra de pesquisa retorne resultados reais de produtos.
- [ ] **Checkout e Pagamentos**: Finalizar a tela de checkout e preparar a integração com Mercado Pago/Stripe.
- [ ] **Tema das Telas de Autenticação**: Refazer/Ajustar profundamente a tela de Login e a tela de Cadastro para seguirem o tema exato e a identidade visual do site (fugindo do padrão rígido do Breeze).

### Tarefas Futuras
- [ ] Finalizar o Painel Administrativo.
- [ ] Testes gerais de responsividade e fluxo de compra.

---

## 📅 Diário de Bordo (Registro de Atividades)

### 01/06/2026
- **Análise Inicial**: Realizada a varredura na estrutura de pastas (`admin/`, `config/`, `css/`, `includes/`, etc).
- **Diagnóstico**: Identificado que o projeto utiliza PHP procedural misturado com HTML, PDO para banco de dados e arquivos com lógica de exibição unida à lógica de negócios.
- **Criação de Documentação**: 
  - Gerado o `implementation_plan.md` no painel do assistente com os passos para profissionalizar o app.
  - Criado este arquivo `BACKLOG.md` no código fonte do projeto para acompanhamento das próximas fases.
