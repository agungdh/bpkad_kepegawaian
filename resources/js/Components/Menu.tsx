import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faChartLine, faUsers } from '@fortawesome/free-solid-svg-icons'
import { Link } from '@inertiajs/react';

export default function Menu() {
    return (
        <aside
            className="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
            aria-label="Sidenav"
            id="drawer-navigation"
        >
            <div className="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
                <ul className="space-y-2">
                    <li>
                        <Link
                            href="/dashboard"
                            className="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        >
                            <FontAwesomeIcon icon={faChartLine} />
                            <span className="ml-3">Dashboard</span>
                        </Link>
                    </li>
                    <li>
                        <Link
                            href="/pegawai"
                            className="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                        >
                            <FontAwesomeIcon icon={faUsers} />
                            <span className="ml-3">Pegawai</span>
                        </Link>
                    </li>
                </ul>
            </div>
        </aside>
    );
}
