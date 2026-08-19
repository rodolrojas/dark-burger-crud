import { CircleX } from 'lucide-react';
export default function Error() {
    return (
        <div className="my-3 px-3 py-2 border border-red-300 bg-red-50 flex items-center justify-start rounded-md">
            <CircleX strokeWidth={3} className="text-red-700 mr-3"/>
            An error ocurred
        </div>
    )
}