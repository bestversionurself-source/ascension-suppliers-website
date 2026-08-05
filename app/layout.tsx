import type { Metadata } from "next";
import "./globals.css";

export const metadata: Metadata = {
  title: { default: "Ascension Suppliers | Design. Develop. Deliver.", template: "%s | Ascension Suppliers" },
  description: "Ascension Suppliers creates custom websites, responsive designs, e-commerce solutions, WordPress websites and SEO strategies.",
  other: {
    "codex-preview": "development",
  },
  icons: {
    icon: "/favicon.svg",
    shortcut: "/favicon.svg",
  },
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="en">
      <body>{children}</body>
    </html>
  );
}
