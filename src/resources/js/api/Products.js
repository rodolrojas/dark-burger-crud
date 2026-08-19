export default class ProductsApi { 
    static async getProduct(productId) {
        await axios.get(`/api/v1/products/${productId}`).then((response) => {
            return response.data;
        });
    }

    static async addProduct(product) {
        await axios.post("/api/v1/products", product).then((response) => {
            return response.data;
        });
    }

    static async removeProduct(productId) {
        await axios.delete(`/api/v1/products/${productId}`).then((response) => {
            return response.data;
        });
    }

    static async updateProduct(productId, updatedProduct) {
        await axios
            .put(`/api/v1/products/${productId}`, updatedProduct)
            .then((response) => {
                return response.data;
            });
    }
}