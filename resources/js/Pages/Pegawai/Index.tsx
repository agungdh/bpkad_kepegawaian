import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { CompactTable } from '@table-library/react-table-library/compact';

export default function Menu() {
    const nodes = [
        {
            id: '0',
            name: 'Shopping List',
            deadline: new Date(2020, 1, 15),
            type: 'TASK',
            isComplete: true,
            nodes: 3,
        },
    ];

    const COLUMNS = [
        { label: 'Task', renderCell: (item: any) => item.name },
        {
            label: 'Deadline',
            renderCell: (item: any) =>
                item.deadline.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                }),
        },
        { label: 'Type', renderCell: (item: any) => item.type },
        {
            label: 'Complete',
            renderCell: (item: any) => item.isComplete.toString(),
        },
        { label: 'Tasks', renderCell: (item: any) => item.nodes },
    ];

    const data = { nodes };

    return (

        <AuthenticatedLayout>
            <section className="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5 antialiased">
                <div className="mx-auto max-w-screen-xl px-4 lg:px-12">
                    <CompactTable columns={COLUMNS} data={data} />
                </div>
            </section>
        </AuthenticatedLayout>


    )
}