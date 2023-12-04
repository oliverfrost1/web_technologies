import React, {
    useState,
    ReactNode,
    createContext,
    useMemo,
    Dispatch,
    SetStateAction,
} from "react";
import { Todo } from "../types/todoTypes";

interface KanbanBoardProviderProps {
    children: ReactNode;
}

const KanbanBoardContext = createContext<{
    todo: Todo[];
    doing: Todo[];
    done: Todo[];
    setTodo: Dispatch<SetStateAction<Todo[]>> | null;
    setDoing: Dispatch<SetStateAction<Todo[]>> | null;
    setDone: Dispatch<SetStateAction<Todo[]>> | null;
}>({
    todo: [],
    doing: [],
    done: [],
    setTodo: () => void 0,
    setDoing: () => void 0,
    setDone: () => void 0,
});

const KanbanBoardProvider: React.FC<KanbanBoardProviderProps> = ({
    children,
}) => {
    const [todo, setTodo] = useState<Todo[]>([]);
    const [doing, setDoing] = useState<Todo[]>([]);
    const [done, setDone] = useState<Todo[]>([]);

    const value = useMemo(() => {
        return {
            todo,
            doing,
            done,
            setTodo,
            setDoing,
            setDone,
        };
    }, [todo, doing, done]);

    return (
        <KanbanBoardContext.Provider value={value}>
            {children}
        </KanbanBoardContext.Provider>
    );
};

export { KanbanBoardContext, KanbanBoardProvider };
