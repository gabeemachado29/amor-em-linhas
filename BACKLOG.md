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
- [x] Estruturar adequadamente o CSS/JS na pasta `public/` e refinar o estilo.
- [x] Preparar a integração com gateways de pagamento (Mercado Pago / Stripe) como alternativas ao PIX.

### Prioridade Alta (Sessão 02/06 — Concluído)
- [x] **Barra de Pesquisa**: Implementar a lógica de busca no backend para que a barra de pesquisa retorne resultados reais de produtos.
- [x] **Tema das Telas de Autenticação**: Refazer/Ajustar profundamente a tela de Login e a tela de Cadastro para seguirem o tema exato e a identidade visual do site (fugindo do padrão rígido do Breeze).
- [x] **Segurança**: Middleware admin, criptografia de sessão, sanitização de inputs, regras fortes de senha.
- [x] **Design Premium**: CSS redesenhado com tipografia premium, animações, glassmorphism, dark mode aprimorado.
- [x] **Footer**: Footer elegante com links de navegação e contato.
- [x] **Carrinho**: Correção de memory leak, controles de quantidade (+/-), badge dinâmico.

### Sessão 10/06 — Concluído ✅
- [x] **Checkout e Pagamentos**: Tela de checkout completa com formulário de endereço de entrega, busca automática por CEP (ViaCEP), seleção de método de pagamento (PIX/Mercado Pago).
- [x] **Painel Administrativo Finalizado**: Dashboard com dados reais (vendas do dia, pedidos pendentes, faturamento mensal, total de clientes), gráfico de vendas dos últimos 7 dias, últimos pedidos.
- [x] **Gestão de Clientes**: Tela administrativa de clientes com busca, detalhes individuais com histórico de pedidos.
- [x] **Integração Mercado Pago**: Service class completa (`MercadoPagoService`), webhook para notificações, toggle no painel admin, configuração via `.env`.
- [x] **Responsividade**: Checkout responsivo com media queries mobile, cards de estatísticas adaptáveis.

### Tarefas Futuras
- [ ] Testes gerais de responsividade e fluxo de compra em dispositivos reais.
- [ ] Deploy em produção.
- [ ] Configurar credenciais do Mercado Pago (sandbox → produção).

---

## 📅 Diário de Bordo (Registro de Atividades)

### 10/06/2026 (Sessão 3 — Noturna)
- **Checkout Completo**:
  - Criada tela intermediária de checkout (`checkout/index.blade.php`) com formulário completo de endereço.
  - Formulário com validação e campos: Rua, Número, Complemento, Bairro, Cidade, Estado (select), CEP.
  - Busca automática de CEP via API ViaCEP (preenchimento automático dos campos).
  - Máscara de CEP no input (00000-000).
  - Seleção de forma de pagamento: PIX (funcional) ou Cartão via Mercado Pago (preparado).
  - Resumo do pedido em sidebar sticky com itens, subtotal, frete e total.
  - Migration criada para campos de endereço e método de pagamento na tabela `pedidos`.
  - Fluxo atualizado: Carrinho → Checkout → Pagamento.
- **Painel Administrativo Finalizado**:
  - Criado `DashboardController` com queries reais para todas as métricas.
  - Dashboard redesenhado com stat cards premium (Vendas Hoje, Pendentes, Produtos, Faturamento Mês, Clientes).
  - Gráfico de vendas dos últimos 7 dias em CSS puro (sem dependências externas).
  - Tabela de últimos 5 pedidos na dashboard.
  - Criado `ClienteController` com listagem, busca (nome/email/CPF) e detalhes.
  - Views: `admin/clientes/index.blade.php` e `admin/clientes/show.blade.php`.
  - Sidebar do admin atualizado com link "Clientes".
- **Integração Mercado Pago**:
  - Criado `app/Services/MercadoPagoService.php` com métodos `criarPreferencia()` e `processarWebhook()`.
  - Rota de webhook (`POST /checkout/mercadopago/webhook`) para receber notificações do MP.
  - Configuração via `config/services.php` e `.env`.
  - Toggle de ativação no painel admin (Configurações → Mercado Pago).
  - Migration para campo `mercadopago_ativo` na tabela `configuracao_lojas`.
  - Fallback automático para PIX se MP falhar.
- **Detalhes de Pedido Enriquecidos**:
  - Admin pedido show agora exibe endereço de entrega e método de pagamento.
  - User pedido show agora exibe endereço de entrega quando disponível.

### 02/06/2026 (Sessão 2 — Noturna)
- **Segurança Implementada**:
  - Criado `AdminMiddleware` para proteger rotas admin (verifica `tipo_perfil`).
  - Registrado middleware no `bootstrap/app.php`.
  - Sessões agora criptografadas (`SESSION_ENCRYPT=true`).
  - Locale configurado para pt_BR.
  - Regras de senha fortalecidas (min 8, maiúsculas, minúsculas, números).
  - Sanitização de inputs no registro (strip_tags, trim, regex para telefone/CPF).
  - Rotas admin protegidas com middleware `auth` + `admin`.
- **Design Premium**:
  - CSS totalmente reescrito com sistema de design tokens (500+ linhas).
  - Google Fonts: Playfair Display (títulos) + Inter (corpo).
  - Micro-animações: fade-in-up staggered nos cards, hover scales, shimmer nos botões.
  - Dark mode aprimorado com transições suaves.
  - Navbar: ícones SVG, badge de carrinho dinâmico, busca funcional.
  - Todas as telas de auth redesenhadas (login, registro, esqueceu senha, reset, confirmação, verificação).
  - Registro agora com campos de telefone e CPF com máscaras de input.
  - Footer premium com links de navegação, contato e redes sociais.
  - Página de produto com breadcrumbs, trust badges e price tag estilizada.
  - Carrinho com controles de quantidade (+/-) e resumo sticky.
- **Funcionalidade de Busca**:
  - Criado `BuscaController` com busca por nome/descrição.
  - Criada view `busca.blade.php` com grid de resultados e paginação.
  - Barra de pesquisa na navbar agora funcional (GET /busca?q=...).

### 01/06/2026
- **Análise Inicial**: Realizada a varredura na estrutura de pastas (`admin/`, `config/`, `css/`, `includes/`, etc).
- **Diagnóstico**: Identificado que o projeto utiliza PHP procedural misturado com HTML, PDO para banco de dados e arquivos com lógica de exibição unida à lógica de negócios.
- **Criação de Documentação**: 
  - Gerado o `implementation_plan.md` no painel do assistente com os passos para profissionalizar o app.
  - Criado este arquivo `BACKLOG.md` no código fonte do projeto para acompanhamento das próximas fases.
