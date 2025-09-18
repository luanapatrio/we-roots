// carrinho.js

class CartManager {
    constructor() {
        this.products = [];
        this.shippingCost = 0.00; // Custo fixo de entrega
        this.initializeProducts();
        this.setupEventListeners();
        this.updateOrderSummary(); // Atualiza o resumo inicial com valores zerados
    }

    initializeProducts() {
        const productElements = document.querySelectorAll('.product-card');
        
        productElements.forEach(element => {
            const name = element.querySelector('h3').textContent;
            const priceText = element.querySelector('.price-info').textContent;
            const price = parseFloat(priceText.replace(/[^0-9,]/g, '').replace(',', '.'));
            const select = element.querySelector('select');
            
            // Inicializa com quantidade 0
            this.products.push({
                name: name,
                price: price,
                quantity: 0
            });

            // Define o valor inicial do select como 0
            select.value = "0";
            
            // Atualiza o preço exibido para R$0,00
            const priceElement = element.querySelector('.price');
            priceElement.textContent = 'R$0,00';
        });
    }

    setupEventListeners() {
        document.querySelectorAll('.quantity-control select').forEach((select, index) => {
            select.addEventListener('change', () => {
                this.updateProductQuantity(index, parseInt(select.value));
            });
        });

        const cepInput = document.getElementById('cep');
        if (cepInput) {
            cepInput.addEventListener('input', this.handleCepInput.bind(this));
        }

        const calculateButton = document.querySelector('.btn-calculate');
        if (calculateButton) {
            calculateButton.addEventListener('click', this.handleCalculateShipping.bind(this));
        }
    }

    updateProductQuantity(index, quantity) {
        // Atualiza a quantidade do produto
        this.products[index].quantity = quantity;
        
        // Atualiza o preço exibido do produto
        const productCard = document.querySelectorAll('.product-card')[index];
        const priceElement = productCard.querySelector('.price');
        const total = this.products[index].price * quantity;
        
        // Atualiza o preço mostrado no card do produto
        if (quantity === 0) {
            priceElement.textContent = 'R$0,00';
        } else {
            priceElement.textContent = `R$${total.toFixed(2).replace('.', ',')}`;
        }

        // Atualiza o resumo do pedido
        this.updateOrderSummary();
    }

    updateOrderSummary() {
        // Calcula totais
        const totalQuantity = this.products.reduce((sum, product) => sum + product.quantity, 0);
        const subtotal = this.products.reduce((sum, product) => sum + (product.price * product.quantity), 0);
        
        // Se não houver produtos selecionados, não adiciona o frete
        const total = totalQuantity > 0 ? subtotal : 0;
        const totalWithShipping = totalQuantity > 0 ? total + this.shippingCost : 0;

        // Atualiza quantidade
        const quantityElement = document.querySelector('.summary-row:first-child span:last-child');
        quantityElement.textContent = totalQuantity;

        // Atualiza valor total sem frete
        const subtotalElement = document.querySelector('.summary-row:nth-child(2) span:last-child');
        subtotalElement.textContent = `R$${total.toFixed(2).replace('.', ',')}`;

        // Atualiza valor total com frete
        const totalElement = document.querySelector('.summary-row.total span:last-child');
        totalElement.textContent = `R$${totalWithShipping.toFixed(2).replace('.', ',')}`;

        // Atualiza estado do botão continuar
        const continueButton = document.querySelector('.btn-continue');
        continueButton.disabled = totalQuantity === 0;
        continueButton.style.opacity = totalQuantity === 0 ? '0.5' : '1';
    }

    handleCepInput(event) {
        let value = event.target.value;
        value = value.replace(/\D/g, '');
        
        if (value.length > 5) {
            value = value.slice(0, 5) + '-' + value.slice(5);
        }
        
        event.target.value = value;
    }

    handleCalculateShipping() {
        const cep = document.getElementById('cep').value;
        
        if (cep.length !== 9) {
            alert('Por favor, digite um CEP válido');
            return;
        }

        this.updateOrderSummary();
    }
}

// Inicializa o gerenciador do carrinho quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    new CartManager();
});