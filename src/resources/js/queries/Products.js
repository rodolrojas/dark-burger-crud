import { useQuery } from "@tanstack/react-query";
import ProductsApi from "../api/Products";
import axios from "axios";


const getProducts = async () => {
    const response = await axios.get("/api/v1/products");
    return response.data;
};

const useGetProducts = () => 
    useQuery({
        queryKey: ["products"],
        queryFn: getProducts,
    });

export { useGetProducts };