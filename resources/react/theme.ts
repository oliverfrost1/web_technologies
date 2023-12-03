import { createTheme } from "@mui/material/styles";

export const theme = createTheme({
    palette: {
        mode: "light",
        background: {
            default: "#ECECEC",
        },
        primary: {
            main: "#f89100",
            contrastText: "#FFFFFF",
        },
        secondary: {
            main: "#333",
            contrastText: "#FFFFFF",
        },
    },
    typography: {
        button: {
            textTransform: "none",
        },
    },
});
