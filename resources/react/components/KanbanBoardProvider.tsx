import React, {
    useState,
    ReactNode,
    createContext,
    useMemo,
    Dispatch,
    SetStateAction,
    useEffect,
    useCallback,
} from "react";
import { Todo } from "../types/todoTypes";
import { getTodos } from "../api/KanbanApiEndpoints";

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
    refetch: () => void;
    fetchingTodoError: string | null;
}>({
    todo: [],
    doing: [],
    done: [],
    setTodo: () => void 0,
    setDoing: () => void 0,
    setDone: () => void 0,
    refetch: () => void 0,
    fetchingTodoError: null,
});

const KanbanBoardProvider: React.FC<KanbanBoardProviderProps> = ({
    children,
}) => {
    const [todo, setTodo] = useState<Todo[]>([]);
    const [doing, setDoing] = useState<Todo[]>([]);
    const [done, setDone] = useState<Todo[]>([]);
    const [fetchingTodoError, setFetchingTodoError] = useState<string | null>(
        null
    );

    useEffect(() => {
        fetchTodos();
    }, []);

    const fetchTodos = useCallback(() => {
        getTodos()
            .then((response) => {
                if (!response) return;
                setTodo(
                    response.filter((todo: Todo) => todo.status === "todo")
                );
                setDoing(
                    response.filter((todo: Todo) => todo.status === "doing")
                );
                setDone(
                    response.filter((todo: Todo) => todo.status === "done")
                );
                setFetchingTodoError(null);
            })
            .catch(() => {
                setFetchingTodoError(
                    "Error in fetching Kanban board. Please try again."
                );
            });
    }, [setTodo, setDoing, setDone]);

    const refetch = useCallback(() => {
        fetchTodos();
    }, [fetchTodos]);

    const value = useMemo(() => {
        return {
            todo,
            doing,
            done,
            setTodo,
            setDoing,
            setDone,
            refetch,
            fetchingTodoError,
        };
    }, [todo, doing, done, refetch]);

    return (
        <KanbanBoardContext.Provider value={value}>
            {children}
        </KanbanBoardContext.Provider>
    );
};

export { KanbanBoardContext, KanbanBoardProvider };
