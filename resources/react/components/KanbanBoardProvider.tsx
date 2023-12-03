import React, { useState, ReactNode, createContext, useMemo } from "react";
import { Todo } from "../types/todoTypes";

interface KanbanBoardProviderProps {
    children: ReactNode;
}

const KanbanBoardContext = createContext<{
    todo: Todo[];
    doing: Todo[];
    done: Todo[];
}>({ todo: [], doing: [], done: [] });

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
        };
    }, [todo, doing, done]);

    return (
        <KanbanBoardContext.Provider value={value}>
            {children}
        </KanbanBoardContext.Provider>
    );
};

export { KanbanBoardContext, KanbanBoardProvider };
