import ApplicationLogo from '@/Components/ApplicationLogo';
import { Link } from '@inertiajs/react';
import { PropsWithChildren } from 'react';

export default function DefaultLayout({ children }: PropsWithChildren) {
    return (
        <>
            {children}
        </>
    );
}
