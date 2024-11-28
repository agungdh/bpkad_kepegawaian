import DefaultLayout from "@/Layouts/DefaultLayout"
import { Payment, columns } from "./columns"
import { DataTable } from "./data-table"

function getData(): Payment[] {
    return [
        {
            id: "728ed52f",
            amount: 100,
            status: "pending",
            email: "m@example.com",
        },
    ]
}

export default function Index() {
    const data = getData()

    return (
        <DefaultLayout>
            <div className="container mx-auto py-10">
                <DataTable columns={columns} data={data} />
            </div>
        </DefaultLayout>
    )
}
