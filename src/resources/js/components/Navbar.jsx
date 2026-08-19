import clsx from "clsx";
import { Link } from "react-router";

export default function Navbar() {
  const linkClassNames = clsx([
    "transition-all",
    "font-bold",
    "flex",
    "align-center",
    "justify-center",
    "mx-2",
    "uppercase",
    "text-gray-400",
    "hover:text-gray-100",
  ]);
  return (
    <nav className="bg-gray-900 text-white">
      <div className="mx-auto flex max-w-5xl gap-6 p-4">
        <div className="mr-5">🍔 Dark Burger Co.</div>
        <Link to="/" className={linkClassNames}>
          Inicio
        </Link>

        <Link to="/about" className={linkClassNames}>
          Acerca de
        </Link>

        <Link to="/products" className={linkClassNames}>
          Productos
        </Link>
      </div>
    </nav>
  );
}
