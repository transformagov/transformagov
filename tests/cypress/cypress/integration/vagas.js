describe("As a user, I want to see the list of vagas", () => {
	beforeEach(() => {
		cy.visit("/");
		cy.wait(500);
		cy.get("#cpf").click().type("05863674032");
		cy.get("#senha").click().type("usugestor123");
		cy.get("input[type=submit]").click();
		cy.get("a[href='http://localhost:8080/Vagas/index']").click();
		cy.wait(1000);
	})

	it("acessa a pagina de vagas", () => {
		cy.get('.col-lg-8 h4').should('include.text', 'Lista de vagas');
	});

	it("acessa a pagina de nova vaga", () => {
		cy.get("a[href='http://localhost:8080/Vagas/create']").click();
		cy.get('.col-lg-8 h4').should('include.text', 'Nova vaga');
	});

	it("verifica o formulário", () => {
		cy.get("a[href='http://localhost:8080/Vagas/create']").click();
		cy.get(".form-control[name='nome']").should('have.value', '');
		cy.get(".form-control[name='descricao']").should('have.value', '');
		cy.get(".form-control[name='instituicao']").should('have.value', '0');
	});
});
