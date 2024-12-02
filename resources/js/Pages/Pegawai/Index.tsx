import DefaultLayout from "@/Layouts/DefaultLayout"
import { DataTable } from "./data-table"

export default function Index({ count }: { count: number }) {
    return (
        <DefaultLayout>
            <div className="container mx-auto py-10">
                <DataTable count={count} />
            </div>
        </DefaultLayout>
    )
}
