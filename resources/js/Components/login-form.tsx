import { Button } from "@/Components/ui/button"
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle,
} from "@/Components/ui/card"
import { Input } from "@/Components/ui/input"
import { Label } from "@/Components/ui/label"
import { z } from "zod"
import { zodResolver } from "@hookform/resolvers/zod"
import { useForm } from "react-hook-form"
import {
  Form,
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from "@/Components/ui/form"
import axios from "axios"
import { router } from "@inertiajs/react"
import { AxiosError } from "axios"

const formSchema = z.object({
  username: z.string(),
  password: z.string(),
})

export function LoginForm() {
  const form = useForm<z.infer<typeof formSchema>>({
    resolver: zodResolver(formSchema),
    defaultValues: {
      username: "",
      password: "",
    },
  })

  async function onSubmit(values: z.infer<typeof formSchema>) {
    try {
      let res = await axios.post('/login', values)
      let data = res.data
    } catch (e) {
      if (e instanceof AxiosError) {
        if (e.status == 422) {
          let errors = e.response?.data?.errors

          for (const key in errors) {
            const element = errors[key]

            // @ts-ignore
            form.setError(key, {
              type: "custom",
              message: element[0],
            })
          }
        }
      }

      throw e
    }

    router.visit('/dashboard')
  }

  return (
    <Card className="mx-auto max-w-sm">
      <CardHeader>
        <CardTitle className="text-2xl">Login</CardTitle>
        <CardDescription>
          Enter your user info below to login to your account
        </CardDescription>
      </CardHeader>
      <CardContent>
        <Form {...form}>
          <form onSubmit={form.handleSubmit(onSubmit)} className="space-y-8">
            <div className="grid gap-4">
              <FormField
                control={form.control}
                name="username"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel htmlFor="username">Username</FormLabel>
                    <FormControl>
                      <Input {...field}
                        id="username"
                        placeholder="Username"
                        autoComplete="username"
                        required
                        {...field}
                      />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />
              <FormField
                control={form.control}
                name="password"
                render={({ field }) => (
                  <FormItem>
                    <FormLabel htmlFor="password">Password</FormLabel>
                    <FormControl>
                      <Input {...field}
                        type="password"
                        id="password"
                        placeholder="Password"
                        autoComplete="current-password"
                        required
                        {...field}
                      />
                    </FormControl>
                    <FormMessage />
                  </FormItem>
                )}
              />
              <Button disabled={form.formState.isSubmitting} type="submit" className="w-full">
                Login
              </Button>
            </div>
          </form>
        </Form>
      </CardContent>
    </Card>
  )
}
