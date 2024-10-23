'use client';
import Navbar from "@/app/components/navbar";
import {useEffect} from "react";
import Cookies from "js-cookie";
import {useRouter} from "next/navigation";
import {TOKEN} from "@/lib/constant";

export default function RootLayout({
                                     children,
                                   }: Readonly<{
  children: React.ReactNode;
}>) {
  const router = useRouter();

  useEffect(() => {
    if (!Cookies.get(TOKEN)) {
      router.push('/')
    }
  }, []);
  return (
    <div>
      <Navbar />
      {children}
    </div>
  );
}
