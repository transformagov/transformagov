describe("My First Test", () => {
	it("reaches the login page", () => {
		cy.visit("/");
		const element = cy.get(".h3");
		expect(element).textContent = "Entre no sistema";
	});
});
