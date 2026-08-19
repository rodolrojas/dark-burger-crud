import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import ProductTable from "../components/Products/ProductTable";

export default function Products() {
    return (
        <div>
            <h1 className="text-4xl font-bold">
                Products
            </h1>
            <ProductTable/>
        </div>
    )
}