import { AppSidebar } from "@/Components/app-sidebar"
import {
    Breadcrumb,
    BreadcrumbItem,
    BreadcrumbLink,
    BreadcrumbList,
    BreadcrumbPage,
    BreadcrumbSeparator,
} from "@/Components/ui/breadcrumb"
import { Button } from "@/Components/ui/button"
import { Separator } from "@/Components/ui/separator"
import {
    SidebarInset,
    SidebarProvider,
    SidebarTrigger,
} from "@/Components/ui/sidebar"
import { User } from "@/models/user"
import { Link, usePage } from "@inertiajs/react"
import { PropsWithChildren } from "react"

export default function DefaultLayout({ children }: PropsWithChildren<{}>) {
    const user: User = usePage().props.auth.user;

    if (user.pegawai) {
        user.profile = user.pegawai
    }

    if (user.honorer) {
        user.profile = user.honorer
    }

    return (
        <SidebarProvider>
            <AppSidebar />
            <SidebarInset>
                <header className="flex h-16 shrink-0 items-center gap-2 border-b px-4">
                    <SidebarTrigger className="-ml-1" />
                    <Separator orientation="vertical" className="mr-2 h-4" />
                    <Breadcrumb>
                        <BreadcrumbList>
                            <BreadcrumbItem className="hidden md:block">
                                <BreadcrumbLink href="#">
                                    Building Your Application
                                </BreadcrumbLink>
                            </BreadcrumbItem>
                            <BreadcrumbSeparator className="hidden md:block" />
                            <BreadcrumbItem>
                                <BreadcrumbPage>Data Fetching</BreadcrumbPage>
                            </BreadcrumbItem>
                        </BreadcrumbList>
                    </Breadcrumb>
                    <Separator orientation="vertical" className="mr-2 h-4" />
                    <p>{user.username} - {user.profile.nama}</p>
                    <Separator orientation="vertical" className="mr-2 h-4" />
                    <Link href="/logout"><Button>Logout</Button></Link>
                </header>
                {children}
            </SidebarInset>
        </SidebarProvider>
    )
}
