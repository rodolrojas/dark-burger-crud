import { Cross, Pencil, Trash } from 'lucide-react';
import { useGetProducts } from '../../queries/Products'
import Error from '../Error';
import Loading from '../Loading';

export default function ProductTable() {
    
    const {isPending, data, error} = useGetProducts();
    if (isPending) {
        return <Loading/>
    }
    if (error) {
        return <Error/>
    }
    return (
        <div className="my-5">
            <table className='table w-full'>
                <thead>
                    <tr className='table-row'>
                        <th className='table-header p-3 border-b border-b-zinc-300'>Name</th>
                        <th className='table-header p-3 border-b border-b-zinc-300'>Description</th>
                        <th className='table-header p-3 border-b border-b-zinc-300'>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {data.data.map((product) => (
                        <tr key={product.id} className='even:bg-slate-200'>
                            <td className='text-sm px-1 py-1.5'>{product.name}</td>
                            <td className='text-sm px-1 py-1.5'>{product.description}</td>
                            <td className='text-sm px-1 py-1.5 flex justify-around'>
                                <button className='btn-xs btn-primary' onClick={() => true}>
                                    <Pencil width={13} className='mr-1.5'/>
                                    Edit
                                </button>
                                <button className='btn-xs btn-danger' onClick={() => true}>
                                    <Trash width={13} className='mr-1.5'/>
                                    Delete
                                </button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}