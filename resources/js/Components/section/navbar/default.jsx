import { Menu } from "lucide-react";
import { cn } from "../../../utils/cn";
import { Button } from "../../ui/button";
import {
  Navbar as NavbarComponent,
  NavbarLeft,
  NavbarRight,
} from "../../ui/navbar";
import { Sheet, SheetContent, SheetTrigger } from "../../ui/sheet";
import Rajakon from "../../logos/rajakon";

const desktopLinks = [
  { text: "Tentang", href: "/#tentang" },
  { text: "Layanan", href: "/#layanan" },
  { text: "Klien", href: "/#klien" },
  { text: "Produk", href: "/#produk" },
  { text: "Blog", href: "/blog" },
  { text: "Dokumentasi", href: "/#dokumentasi" },
  { text: "Kontak", href: "/#kontak" },
];

export default function Navbar({
  logo = <Rajakon />,
  homeUrl = "/",
  mobileLinks = [
    { text: "Tentang", href: "/#tentang" },
    { text: "Layanan", href: "/#layanan" },
    { text: "Klien", href: "/#klien" },
    { text: "Produk", href: "/#produk" },
    { text: "Blog", href: "/blog" },
    { text: "Dokumentasi", href: "/#dokumentasi" },
    { text: "Kontak", href: "/#kontak" },
  ],
  actions = [
    {
      text: "Konsultasi Gratis",
      href: "https://wa.me/081221622132",
      isButton: true,
      variant: "default",
    },
  ],
  showNavigation = true,
  customNavigation,
  className,
}) {
  return (
    <header className={cn("sticky top-0 z-50 -mb-4 px-4 pb-4", className)}>
      <div className="fade-bottom bg-background/15 absolute left-0 h-24 w-full backdrop-blur-lg" />

      <div className="max-w-container relative mx-auto">
        <NavbarComponent>
          <NavbarLeft>
            <a href={homeUrl} className="flex items-center gap-2 text-xl font-bold">
              {logo}
            </a>

            {showNavigation && (
              customNavigation || (
                <nav className="hidden md:flex items-center gap-6 ml-6">
                  {desktopLinks.map((link, index) => (
                    <a
                      key={index}
                      href={link.href}
                      className="text-sm text-muted-foreground hover:text-foreground transition-colors"
                    >
                      {link.text}
                    </a>
                  ))}
                </nav>
              )
            )}
          </NavbarLeft>

          <NavbarRight>
            {actions.map((action, index) => {
              if (action.isButton) {
                return (
                  <Button
                    key={index}
                    variant={action.variant || "default"}
                    size="sm"
                    className="hidden text-sm md:block"
                    onClick={() => window.open(action.href, "_blank")}
                  >
                    {action.icon}
                    {action.text}
                    {action.iconRight}
                  </Button>
                );
              }
              return (
                <a
                  key={index}
                  href={action.href}
                  className="hidden text-sm md:block hover:text-primary transition-colors"
                >
                  {action.text}
                </a>
              );
            })}

            <Sheet>
              <SheetTrigger asChild>
                <Button variant="ghost" size="icon" className="shrink-0 md:hidden">
                  <Menu className="size-5" />
                  <span className="sr-only">Toggle navigation menu</span>
                </Button>
              </SheetTrigger>

              <SheetContent side="right" className="w-[300px] sm:w-[400px]">
                <nav className="grid gap-6 text-lg font-medium mt-8">
                  <a href={homeUrl} className="flex items-center gap-2 text-xl font-bold mb-6">
                    {logo}
                  </a>

                  {mobileLinks.map((link, index) => (
                    <a
                      key={index}
                      href={link.href}
                      className="text-muted-foreground hover:text-foreground transition-colors block py-2"
                    >
                      {link.text}
                    </a>
                  ))}

                  <div className="flex flex-col gap-3 mt-6">
                    {actions.map((action, index) => {
                      if (action.isButton) {
                        return (
                          <Button
                            key={index}
                            variant={action.variant || "default"}
                            size="lg"
                            className="w-full justify-center"
                            onClick={() => window.open(action.href, "_blank")}
                          >
                            {action.icon}
                            {action.text}
                            {action.iconRight}
                          </Button>
                        );
                      }
                      return (
                        <a
                          key={index}
                          href={action.href}
                          className="text-center py-3 text-muted-foreground hover:text-foreground transition-colors"
                        >
                          {action.text}
                        </a>
                      );
                    })}
                  </div>
                </nav>
              </SheetContent>
            </Sheet>
          </NavbarRight>
        </NavbarComponent>
      </div>
    </header>
  );
}