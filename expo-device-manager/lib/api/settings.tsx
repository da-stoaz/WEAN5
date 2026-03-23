import AsyncStorage from "@react-native-async-storage/async-storage";
import React, {
  createContext,
  useCallback,
  useContext,
  useEffect,
  useMemo,
  useState,
} from "react";

const STORAGE_KEY = "device-manager:api-settings";
const DEFAULT_PROTOCOL: ApiProtocol = "http://";
const DEFAULT_HOST = "10.0.2.2:5055";

export type ApiProtocol = "http://" | "https://";

type ApiSettingsState = {
  protocol: ApiProtocol;
  host: string;
};

type ApiSettingsContextValue = {
  protocol: ApiProtocol;
  host: string;
  baseUrl: string;
  isHydrating: boolean;
  setSettings: (next: ApiSettingsState) => Promise<void>;
  resetSettings: () => Promise<void>;
};

const ApiSettingsContext = createContext<ApiSettingsContextValue | null>(null);

function normalizeHost(rawHost: string): string {
  return rawHost.trim().replace(/^https?:\/\//i, "").replace(/\/+$/, "");
}

function buildBaseUrl(protocol: ApiProtocol, host: string): string {
  const normalizedHost = normalizeHost(host);
  if (!normalizedHost) {
    return "";
  }

  return `${protocol}${normalizedHost}`;
}

export function ApiSettingsProvider({ children }: { children: React.ReactNode }) {
  const [protocol, setProtocol] = useState<ApiProtocol>(DEFAULT_PROTOCOL);
  const [host, setHost] = useState(DEFAULT_HOST);
  const [isHydrating, setIsHydrating] = useState(true);

  useEffect(() => {
    let active = true;

    const hydrate = async () => {
      try {
        const raw = await AsyncStorage.getItem(STORAGE_KEY);
        if (!raw || !active) {
          return;
        }

        const parsed = JSON.parse(raw) as Partial<ApiSettingsState>;
        if (parsed.protocol === "http://" || parsed.protocol === "https://") {
          setProtocol(parsed.protocol);
        }

        if (typeof parsed.host === "string") {
          setHost(normalizeHost(parsed.host));
        }
      } catch {
        // Keep defaults if storage is invalid.
      } finally {
        if (active) {
          setIsHydrating(false);
        }
      }
    };

    hydrate();

    return () => {
      active = false;
    };
  }, []);

  const setSettings = useCallback(async (next: ApiSettingsState) => {
    const normalized: ApiSettingsState = {
      protocol: next.protocol,
      host: normalizeHost(next.host),
    };

    setProtocol(normalized.protocol);
    setHost(normalized.host);
    await AsyncStorage.setItem(STORAGE_KEY, JSON.stringify(normalized));
  }, []);

  const resetSettings = useCallback(async () => {
    const defaults = {
      protocol: DEFAULT_PROTOCOL,
      host: DEFAULT_HOST,
    };

    setProtocol(defaults.protocol);
    setHost(defaults.host);
    await AsyncStorage.setItem(STORAGE_KEY, JSON.stringify(defaults));
  }, []);

  const value = useMemo<ApiSettingsContextValue>(
    () => ({
      protocol,
      host,
      baseUrl: buildBaseUrl(protocol, host),
      isHydrating,
      setSettings,
      resetSettings,
    }),
    [host, isHydrating, protocol, resetSettings, setSettings],
  );

  return (
    <ApiSettingsContext.Provider value={value}>
      {children}
    </ApiSettingsContext.Provider>
  );
}

export function useApiSettings() {
  const context = useContext(ApiSettingsContext);

  if (!context) {
    throw new Error("useApiSettings must be used inside ApiSettingsProvider");
  }

  return context;
}

export function getDefaultApiSettings(): ApiSettingsState {
  return {
    protocol: DEFAULT_PROTOCOL,
    host: DEFAULT_HOST,
  };
}
