import { create } from "zustand";
import ProductsApi from "../api/Products";

export const useProductStore = create((set) => ({
  products: [],
}));
