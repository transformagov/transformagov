describe("como usuário, gostaria de gerenciar um grupo de vagas", () => {
	beforeEach(() => {
		cy.visit("/");
		cy.wait(500);
		cy.get("#cpf").click().type("05863674032");
		cy.get("#senha").click().type("usugestor123");
		cy.get("input[type=submit]").click();
	});

	it("cadastra um novo grupo de vagas", () => {
		cy.get("a[href='http://localhost:8080/GruposVagas/index']").click();
		cy.wait(1000);
		cy.get("a[href='http://localhost:8080/GruposVagas/create']").click();
		cy.get("input[name='nome']").type("teste");
		cy.get("select[name='instituicao']").select("AGE");
		cy.get("input[type='submit']").click();
	});

	it("cadastra um segundo grupo de vagas", () => {
		cy.get("a[href='http://localhost:8080/GruposVagas/index']").click();
		cy.wait(1000);
		cy.get("a[href='http://localhost:8080/GruposVagas/create']").click();
		cy.get("input[name='nome']").type("teste2");
		cy.get("select[name='instituicao']").select("AGE");
		cy.get("input[type='submit']").click();
	});

	it("acessa o historico de duplicações", () => {
		cy.get("a[href='http://localhost:8080/GruposVagas/index']").click();
		cy.wait(1000);
		cy.get(
			"a[href='http://localhost:8080/GruposVagas/historico_duplicate_total']"
		).click();
		cy.get("#questoes_table");
	});

	it("acessa o quantitativo de duplicações", () => {
		cy.get("a[href='http://localhost:8080/GruposVagas/index']").click();
		cy.wait(1000);
		cy.get(
			"a[href='http://localhost:8080/GruposVagas/historico_duplicate_quantitativo']"
		).click();
		cy.get("#questoes_table");
	});

	it("verifica grupo de vagas cadastrado", () => {
		cy.get("a[href='http://localhost:8080/GruposVagas/index']").click();
		cy.wait(1000);
		cy.get("tbody")
			.find("tr")
			.eq(0)
			.find(".align-middle")
			.eq(0)
			.should("have.text", "teste");
		cy.get("tbody")
			.find(".align-middle.text-center")
			.eq(0)
			.should("have.text", "AGE");
	});

	it("desativa o grupo teste2", () => {
		cy.get("a[href='http://localhost:8080/GruposVagas/index']").click();
		cy.wait(1000);
		cy.get("tbody")
			.find("tr")
			.eq(1)
			.find(".input-group-prepend")
			.find("button")
			.click()
			.wait(1000)
			.get("a[title='Desativar grupo de vagas']")
			.eq(1)
			.click()
			.wait(1000);
	});

	it("cadastra uma nova vaga", () => {
		cy.get("a[href='http://localhost:8080/Vagas/index']").click();
		cy.wait(1000);
		cy.get("a[href='http://localhost:8080/Vagas/create']").click();
		cy.get("input[name='nome']").type("Novo Candidato");
		cy.get("textarea[name='descricao']").type("Novo candidato");
		cy.get("select[name='instituicao']").select("AGE");
		cy.get("select[name='grupo']").select("teste");
		cy.get("input[name='inicio']").type("01/01/2022 00:00");
		cy.get("input[name='fim']").type("02/01/2022 00:00", { force: true });
		cy.get("input[type='submit']").click({ force: true });
	});

	it("cadastra uma nova questão em uma vaga", () => {
		cy.get("a[href='http://localhost:8080/GruposVagas/index']").click();
		cy.wait(1000);
		cy.get(".input-group-prepend").find("button").eq(0).click();
		cy.wait(1000);
		cy.get("a[href='http://localhost:8080/Questoes/index/97']").eq(0).click();
		cy.get("a[href='http://localhost:8080/Questoes/create/97']").click();
		cy.wait(1000);
		cy.get("textarea[name='descricao']").type(
			"Qual o ano da independência do Brasil?"
		);
		cy.get("select[name='etapa']").select(
			"Etapa 7 - Entrevista com especialista"
		);
		cy.get("select[name='competencia']").select("Capacidade de Comunicação");
		cy.get("input[name='obrigatorio'][value='1']").check();
		cy.get("input[name='eliminatoria'][value='0']").check();
		cy.get("select[name='tipo']").select("Aberta");
		cy.get("input[type='submit']").click({ force: true });
		cy.wait(1000);
	});

	it("acessa pagina de resultados", () => {
		cy.get("a[href='http://localhost:8080/Vagas/index']").click();
		cy.get("a[href='http://localhost:8080/Vagas/resultado/174']").click();
		cy.wait(1000);
		cy.get(".col-lg-4, .text-right")
			.find("button")
			.eq(0)
			.should("include.text", "Recalcular nota bruta");
		cy.get(".col-lg-4, .text-right")
			.find("button")
			.eq(1)
			.should("include.text", "Reprovadas na Habilitação");
		cy.get(".col-lg-4, .text-right")
			.find("button")
			.eq(2)
			.should("include.text", "Detalhamento por competência");
	});
});
