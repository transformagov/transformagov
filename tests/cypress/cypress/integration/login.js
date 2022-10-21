describe("As a user, I want to login on transformagov", () => {
	it("reaches the login page", () => {
		cy.visit("/");
		cy.wait(500);
		cy.get("h3").should("have.text", "Entre no sistema");
	});

	it("login with manager user", () => {
		cy.visit("/");
		cy.get("#cpf").click().type("05863674032");
		cy.get("#senha").click().type("usugestor123");
		cy.get("input[type=submit]").click();
		cy.wait(1000);
	});
});
