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
