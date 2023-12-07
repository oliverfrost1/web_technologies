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
            main: "#FFFFFF",
            contrastText: "#333333",
        },
    },
    typography: {
        button: {
            textTransform: "none",
        },
    },
});
