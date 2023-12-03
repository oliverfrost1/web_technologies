import { createTheme } from "@mui/material/styles";

export const theme = createTheme({
    palette: {
        mode: "light",
        background: {
            default: "#ECECEC",
        },
        primary: {
            main: "#f89100",
            contrastText: "white",
        },
        secondary: {
            main: "#333",
            contrastText: "white",
        },
    },
    typography: {
        button: {
            textTransform: "none",
        },
    },
});
