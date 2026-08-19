import { useGetProducts } from '../../queries/Products'
import Error from '../Error';
import Loading from '../Loading';

export default function ProductTable() {
    
    const {isPending, data, error} = useGetProducts();
    console.log({isPending, data, error})
    if (isPending) {
        return <Loading/>
    }
    if (error) {
        return <Error/>
    }
    return (
        <div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {data.map((product) => (
                        <tr key={product.id}>
                            <td>{product.name}</td>
                            <td>${product.price.toFixed(2)}</td>
                            <td>
                                <button onClick={false}>Delete</button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}