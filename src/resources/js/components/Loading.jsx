import { LoaderCircle } from "lucide-react";

export default function Loading() {
    return (
        <div className="flex items-center justify-center w-full h-full py-6 min-h-9">
            <div className="text-center flex flex-row justify-center items-center">
                <LoaderCircle size={40} className="animate-spin mr-3"/>
                <span className="text-2xl font-medium">
                    Loading
                </span>
            </div>
        </div>
    )
}